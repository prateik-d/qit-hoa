<?php

namespace App\Http\Controllers\API\Admin;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Ammenity;
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
            $ticketCategories = TicketCategory::where('status', 1)
                                ->orderBy('category', 'ASC')
                                ->get();

            $tickets = Ticket::with('user', 'ticketImages', 'ticketCategory', 'assignedUser')
                        ->where('title', 'LIKE', '%'.$request->get('title'). '%')
                        ->whereHas('user', function ($query) use($request) {
                            $query->where(DB::raw('CONCAT(first_name, " ",last_name)'), 'LIKE', '%'.$request->get('created_by'). '%');
                        })
                        ->when($request->has('category'), function ($query) use ($request) {
                            $query->where('ticket_category_id', 'LIKE', '%'.$request->category. '%');
                        })
                        ->when($request->has('status'), function ($query) use ($request) {
                            $query->where('status', 'LIKE', '%'.$request->get('status'). '%');
                        })
                        ->when($request->has('date'), function ($query) use ($request) {
                            $query->where('ticket_date', 'LIKE', '%'.$request->get('date'). '%');
                        })
                        ->get();

            if (count($ticketCategories)) {
                if (count($tickets)) {
                    Log::info('Ticket data displayed successfully.');
                    return $this->sendResponse(['ticketCategories'=> $ticketCategories, 'tickets' => $tickets], 'Ticket data retrieved successfully.');
                } else {
                    return $this->sendError(['ticketCategories'=> $ticketCategories], 'No data found for ticket');
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
            $ticketCategories = TicketCategory::where('status', 1)->orderBy('category', 'ASC')->get();
            $ammenities = Ammenity::orderBy('title', 'ASC')->get();

            if (count($ticketCategories)) {
                Log::info('Ticket categories data displayed successfully.');
                return $this->sendResponse(['ticketCategories'=> $ticketCategories, 'ammenities' => $ammenities], 'Ticket categories data retrieved successfully.');
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
        try {
            $allowedfileExtension = ['pdf','jpg','jpeg','png','xlsx','bmp'];
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
                Log::info('File uploaded successfully.');
                return response()->json(['file uploaded'], 200);
            }
        } catch (Exception $e) {
            Log::error('Failed to upload ticket images due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to upload ticket images.');
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
            $ticket = Ticket::findOrFail($id);
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
            $ticketCategories = TicketCategory::where('status', 1)->orderBy('category', 'ASC')->get();
            $ammenities = Ammenity::orderBy('title', 'ASC')->get();
            $ticket = Ticket::with('user', 'ticketImages', 'ticketCategory', 'assignedUser')->find($id);
            Log::info('Edit ticket data for ticket id: '.$id);
            return $this->sendResponse(['ticketCategories' => $ticketCategories, 'ammenities' => $ammenities, 'ticket' => $ticket], 'Ticket retrieved successfully.');
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
            $input = $request->all();
            $ticket = Ticket::findOrFail($id);
            if ($ticket) {
                $update = $ticket->fill($input)->save();
                if ($update) {
                    if ($request->hasFile('photo')) {
                        // Delete old images to upload new
                        if ($ticket->ticketImages()) {
                            foreach ($ticket->ticketImages as $file) {
                                if (file_exists(storage_path('app/'.$file->img_file_path))) { 
                                    unlink(storage_path('app/'.$file->img_file_path));
                                }
                            }
                            $ticket->ticketImages()->delete();
                        }
                        // Add new images
                        $folder = 'ticket_photos';
                        $input = $request->photo;
                        $files = $request->file('photo');
                        $this->fileUpload($folder, $input, $files, $ticket);
                    }
                    Log::info('Ticket updated successfully for ticket id: '.$id);
                    return $this->sendResponse([], 'Ticket updated successfully.');
                } else {
                    return $this->sendError('Failed to update ticket');     
                }
            } else{
                return $this->sendError('Ticket not found');
            }
        } catch (Exception $e) {
            Log::error('Failed to update ticket data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update ticket.');
        }
    }

    public function closeTicket($id)
    {
        try {
            $ticket = Ticket::where('id', $id)->update(['status' => 'closed']);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        try {
            $tickets = Ticket::where('status', $request->get('status'))->get();
            
            if (count($tickets)) {
                Log::info('Showing tickets for status: '.$request->get('status'));
                return $this->sendResponse($tickets, 'Tickets retrieved successfully.');
            } else {
                return $this->sendError('Tickets data not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve tickets data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve tickets data, tickets not found.');
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
            $ticket = Ticket::findOrFail($id);
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

    /**
     * Remove the resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        try {
            $ids = $request->ids;
            $tickets = Ticket::whereIn('id',explode(",",$ids))->get();
            if ($tickets) {
                foreach ($tickets as $ticket) {
                    if ($ticket->ticketImages()) {
                        foreach ($ticket->ticketImages as $file) {
                            if (file_exists(storage_path('app/'.$file->img_file_path))) { 
                                unlink(storage_path('app/'.$file->img_file_path));
                            }
                        }
                        $ticket->ticketImages()->delete();
                    }
                    $ticket->delete();
                }
                Log::info('Selected tickets deleted successfully');
                return $this->sendResponse([], 'Selected tickets deleted successfully.');
            } else {
                return $this->sendError('Tickets not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete tickets due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete tickets.');
        }
    }

}
