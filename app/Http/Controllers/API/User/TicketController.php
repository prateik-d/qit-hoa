<?php

namespace App\Http\Controllers\API\User;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketImage;
use App\Http\Resources\Ticket as TicketResource;
use App\Http\Requests\StoreTicketRequest;

class TicketController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::guard('api')->user();

            $ticketCategories = TicketCategory::where('status', 1)
                                ->orderBy('category', 'ASC')
                                ->get();

            $ticket = Ticket::with('user', 'ticketImages', 'ticketCategory')
                ->where('created_by', $user->id)
                ->where('title', 'LIKE', '%'.$request->get('title'). '%')
                ->where('status', 'LIKE', '%'.$request->get('status'). '%')
                ->where('created_at', 'LIKE', '%'.$request->get('created_at'). '%')
                ->where('ticket_category_id', 'LIKE' , '%'.$request->get('category').'%')->get();

            if (count($ticketCategories)) {
                if (count($ticket)) {
                    return $this->sendResponse([$ticketCategories, $ticket], 'Ticket retrieved successfully.');
                } else {
                    return response()->json(['Result' => 'No Data not found for ticket'], 404);
                }
            } else {
                return $this->sendError('No data found for categories');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve ticket data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve ticket data.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $ticketCategories = TicketCategory::where('status', 1)
                                ->orderBy('category', 'ASC')
                                ->get();

            if (count($ticketCategories)) {
                Log::info('Ticket categories data displayed successfully.');
                return $this->sendResponse($ticketCategories, 'Ticket categories data retrieved successfully.');
            } else {
                return $this->sendError('No data found for ticket categories.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve ticket categories due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve ticket categories.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request)
    {
        try {
            $input = $request->all();
            $input['created_by'] = Auth::guard('api')->user()->id;
            $ticket = Ticket::create($input);
            if ($ticket) {
                if ($request->hasFile('photo')) {
                    $folder = 'ticket_photos';
                    $input = $request->photo;
                    $files = $request->file('photo');
                    $this->fileUpload($folder, $input, $files, $ticket);
                }
                Log::info('Ticket raised successfully.');
                return $this->sendResponse(new TicketResource($ticket), 'Ticket raised successfully.');
            } else {
                return $this->sendError('Failed to raised ticket');     
            }
        } catch (Exception $e) {
            Log::error('Failed to raised ticket due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to raised ticket.');
        }
    }

    /**
     * File upload for ticket.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileUpload($folder, $input, $files, $ticket)
    {
        $allowedfileExtension=['pdf','jpg','jpeg','png','xlsx'];
        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);
            if($check) {
                foreach((array)$input as $mediaFiles) {
                    $name = $mediaFiles->getClientOriginalName();
                    $filename = $ticket->id.'-'.$name;
                    $path = $mediaFiles->storeAs('public/'.$folder, $filename);
                    $ext  =  $mediaFiles->getClientOriginalExtension();
                    //store image file into directory and db
                    $ticketimages = new TicketImage();
                    $ticketimages->ticket_id = $ticket->id;
                    $ticketimages->img_file_path = $path;
                    $ticketimages->save();
                }
            } else {
                return $this->sendError('invalid_file_format'); 
            }
            return response()->json(['file_uploaded'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = Auth::guard('api')->user();
            $ticket = Ticket::with('ticketImages')->where('created_by', $user->id)->where('id',$id)->first();
            Log::info('Showing ticket data for ticket id: '.$id);
            return $this->sendResponse(new TicketResource($ticket), 'Ticket retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve ticket data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve ticket data, ticket not found.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $user = Auth::guard('api')->user();
            $ticket = Ticket::with('ticketImages')->where('created_by', $user->id)->where('id',$id)->first();
            Log::info('Edit ticket data for ticket id: '.$id);
            return $this->sendResponse(new TicketResource($ticket), 'Ticket retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit ticket data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit ticket data, ticket not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTicketRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $user = Auth::guard('api')->user();
            $ticket = Ticket::where('created_by', $user->id)->where('id',$id)->first();
            if ($ticket) {
                $update = $ticket->fill($input)->save();
                if ($update) {
                    if ($request->hasFile('photo')) {
                        //Delete old images to upload new
                        if ($ticket->ticketImages()) {
                            foreach ($ticket->ticketImages as $file) {
                                if (file_exists(storage_path('app/'.$file->img_file_path))) { 
                                    unlink(storage_path('app/'.$file->img_file_path));
                                }
                            }
                            $ticket->ticketImages()->delete();
                        }
                        //Add new images
                        $folder = 'ticket_photos';
                        $input = $request->photo;
                        $files = $request->file('photo');
                        $this->fileUpload($folder, $input, $files, $ticket);
                    }
                    Log::info('Ticket updated successfully for ticket id: '.$id);
                    return $this->sendResponse([], 'Ticket updated successfully.');
                } else {
                    return $this->sendError('Failed to add ticket');     
                }
            } else{
                return $this->sendError('Cannot update ticket, this ticket is raised by another user.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update ticket data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update ticket.');
        }
    }

    public function closeTicket($id) 
    {
        try {
            $user = Auth::guard('api')->user();
            $ticket = Ticket::where('created_by', $user->id)->where('id', $id)->update(['status' => 'closed']);
            if ($ticket) {
                Log::info('Ticket closed successfully for ticket id: '.$id);
                return response()->json(['Result' => 'Ticket closed successfully.']);
            } else {
                return response()->json(['Result' => 'Ticket not found'], 404);
            }
        } catch (Exception $e) {
            Log::error('Failed to close ticket data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to close ticket.');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = Auth::guard('api')->user();
            $ticket = Ticket::where('created_by', $user->id)->where('id',$id)->first();
            if ($ticket) {
                if ($ticket->ticketImages()) {
                    foreach ($ticket->ticketImages as $file) {
                        if (file_exists(storage_path('app/'.$file->img_file_path))) { 
                            unlink(storage_path('app/'.$file->img_file_path));
                        }
                    }
                    $ticket->ticketImages()->delete();
                }
                $ticket->delete();
                Log::info('Ticket deleted successfully for ticket id: '.$id);
                return $this->sendResponse([], 'Ticket deleted successfully.');
            } else {
                return $this->sendError('Ticket not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete ticket due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete ticket.');
        }
    }
}
