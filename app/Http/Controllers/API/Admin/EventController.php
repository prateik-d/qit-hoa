<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\EventPhoto;
use App\Models\EventCategory;
use App\Models\EventLocation;
use App\Models\User;
use App\Http\Resources\Event as EventResource;
use App\Http\Requests\StoreEventRequest;
class EventController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $locations = EventLocation::where('status', 1)->orderBy('location','asc')->get();

            $events = Event::where('event_title', 'LIKE', '%'.$request->get('title'). '%')
            ->where('start_datetime', 'LIKE' , '%'.$request->get('start_date').'%')
            ->where('end_datetime', 'LIKE' , '%'.$request->get('end_date').'%')
            ->where('event_location_id', 'LIKE', '%'.$request->get('location'). '%')
            ->where('status', 'LIKE', '%'.$request->get('status'). '%')
            ->get();

            if (count($locations)) {
                if (count($events)) {
                    Log::info('Event data displayed successfully.');
                    return $this->sendResponse([$locations, $events], 'Events data retrieved successfully.');
                } else {
                    return $this->sendError('No data found for event.');
                }
            } else {
                return $this->sendError('No data found for locations.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve event data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve event data.');
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
            $locations = EventLocation::where('status', 1)->orderBy('location', 'asc')->get();
            $categories = EventCategory::where('status', 1)->orderBy('category', 'asc')->get();

            if (count($locations) && count($categories)) {
                Log::info('Event locations and categories displayed successfully.');
                return $this->sendResponse([$locations, $categories], 'Event locations and categories displayed successfully.');
            } else {
                return $this->sendError('No data found for event locations and categories.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve event locations and categories due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve event locations and categories.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        try {
            $input = $request->all();
            // $input['organized_by'] = Auth::guard('api')->user()->id;
            $event = Event::create($input);
            if ($event) {
                if ($request->hasFile('photos')) {
                    $folder = 'event_photos';
                    $input = $request->photo;
                    $files = $request->file('photo');
                    $this->fileUpload($folder, $input, $files, $event);
                }
                Log::info('Event added successfully.');
                return $this->sendResponse(new EventResource($event), 'Event created successfully.');
            } else {
                return $this->sendError('Failed to add event.');   
            }
        } catch (Exception $e) {
            Log::error('Failed to add event due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add event.');
        }
    }

    /**
     * File upload for event.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileUpload($folder, $input, $files, $event)
    {
        try {
            $allowedfileExtension = ['pdf','jpg','jpeg','png','xlsx','bmp'];
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension,$allowedfileExtension);
                if($check) {
                    foreach((array)$input as $mediaFiles) {
                        $name = $mediaFiles->getClientOriginalName();
                        $filename = $event->id.'-'.$name;
                        $path = $mediaFiles->storeAs('public/'.$folder, $filename);
                        $ext  =  $mediaFiles->getClientOriginalExtension();
                        //store image file into directory and db
                        $eventimages = new EventPhoto();
                        $eventimages->event_id = $event->id;
                        $eventimages->event_photo_path = $path;
                        $eventimages->save();
                    }
                } else {
                    return $this->sendError('invalid_file_format'); 
                }
                Log::info('File uploaded successfully.');
                return response()->json(['file uploaded'], 200);
            }
        } catch (Exception $e) {
            Log::error('Failed to upload event images due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to upload event images.');
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
            $event = Event::findOrFail($id);
            Log::info('Showing event data for event id: '.$id);
            return $this->sendResponse(new EventResource($event), 'Event retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve event data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve event data, event not found.');
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
            $event = Event::findOrFail($id);
            Log::info('Edit event data for event id: '.$id);
            return $this->sendResponse(new EventResource($event), 'Event retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit event data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit event data, event not found.');
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEventRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $event = Event::findOrFail($id);
            if ($event) {
                $update = $event->fill($input)->save();
                if ($update) {
                    if ($request->hasFile('photos')) {
                        // Delete old images to upload new
                        if ($event->eventImages()) {
                            foreach ($event->eventImages as $file) {
                                if (file_exists(storage_path('app/'.$file->event_photo_path))) { 
                                    unlink(storage_path('app/'.$file->event_photo_path));
                                }
                            }
                            $event->eventImages()->delete();
                        }
                        // Add new images
                        $folder = 'event_photos';
                        $input = $request->photo;
                        $files = $request->file('photo');
                        $this->fileUpload($folder, $input, $files, $event);
                    }
                    Log::info('Event updated successfully for event id: '.$id);
                    return $this->sendResponse([], 'Event updated successfully.');
                } else {
                    return $this->sendError('Failed to update event');      
                }
            } else {
                return $this->sendError('Event not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update event due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update event.');
        }
    }
   
    /**
     * Show archived events.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archivedEvent()
    {
        try {
            $archivedEvent = Auth::guard('api')->user()->events()->where('status', 'archived')->get();
            if ($archivedEvent) {
                Log::info('Showing archived event data for event id: '.$id);
                return $this->sendResponse(new EventResource($archivedEvent), 'Archived events retrieved successfully.');
            } else {
                return $this->sendError('Archived events not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve archived event data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve archived event data, event not found.');
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
            $event = Event::findOrFail($id);
            if ($event) {
                if ($event->eventImages()) {
                    foreach ($event->eventImages as $file) {
                        if (file_exists(storage_path('app/'.$file->event_photo_path))) { 
                            unlink(storage_path('app/'.$file->event_photo_path));
                        }
                    }
                    $event->eventImages()->delete();
                }
                $event->delete();
                Log::info('Event deleted successfully for event id: '.$id);
                return $this->sendResponse([], 'Event deleted successfully.');
            } else {
                return $this->sendError('Event not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete event due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete event.');
        }
    }
}
