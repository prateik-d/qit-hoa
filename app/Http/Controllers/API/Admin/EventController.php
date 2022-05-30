<?php

namespace App\Http\Controllers\API\Admin;
   
use Carbon\Carbon;
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

            $events = Event::with('eventLocation')
            ->where('event_title', 'LIKE', '%'.$request->title. '%')
            ->when($request->has('start_date'), function ($query) use ($request) {
                $query->where('start_datetime', 'LIKE', '%'.$request->start_date. '%');
            })
            ->when($request->has('end_date'), function ($query) use ($request) {
                $query->where('end_datetime', 'LIKE', '%'.$request->end_date. '%');
            })
            ->when($request->has('location'), function ($query) use ($request) {
                $query->where('event_location_id', 'LIKE', '%'.$request->location. '%');
            })
            ->when($request->has('status'), function ($query) use ($request) {
                $query->where('status', 'LIKE', '%'.$request->status. '%');
            })->get();

            if (count($locations)) {
                if (count($events)) {
                    Log::info('Event data displayed successfully.');
                    return $this->sendResponse(['events' => $events, 'locations' => $locations], 'Events data retrieved successfully.');
                } 
                else {
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
                return $this->sendResponse(['locations' => $locations, 'categories' => $categories], 'Event locations and categories displayed successfully.');
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
            $input['organized_by'] = Auth::guard('api')->user();
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
            if ($event->status != 'cancelled') {
                Log::info('Edit event data for event id: '.$id);
                return $this->sendResponse(new EventResource($event), 'Event retrieved successfully.');
            } else {
                Log::error('Cannot edit event data for event id: '.$id.' '.'because the event is cancelled by admin');
                return $this->sendError('Operation failed to edit event data, because the event is cancelled by admin.');
            }
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
                if ($event->status != 'cancelled') {
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
                    Log::error('Cannot update event data for event id: '.$id.' '.'because the event is cancelled by admin');
                    return $this->sendError('Operation failed to update event data, because the event is cancelled by admin.');
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
     * Show upcoming events.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upcomingEvent()
    {
        try {
            $currentDateTime = Carbon::now()->toDateTimeString();
			$upcomingEvents = Event::where('start_datetime', '>', $currentDateTime)->where('status', '!=', 'cancelled')->get();
            if (count($upcomingEvents)) {
                Log::info('Displayed upcoming events successfully');
                return $this->sendResponse($upcomingEvents, 'Upcoming events retrieved successfully.');
            } else {
                return $this->sendError('No data found for upcoming events.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve upcoming events due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve upcoming events, events not found.');
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
			$archivedEvent = Event::where('status', 'archived')->get();
            if (count($archivedEvent)) {
                Log::info('Displayed archived events successfully');
                return $this->sendResponse(new EventResource($archivedEvent), 'Archived events retrieved successfully.');
            } else {
                return $this->sendError('No data found for archived events.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve archived events due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve archived events, events not found.');
        }
    }

    /**
     * update event to cancel.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancelEvent($id)
    {
        try {
            $currentDateTime = Carbon::now()->toDateTimeString();
			$cancelledEvent = Event::where('start_datetime', '>', $currentDateTime)->update('status', 'cancelled');
            if ($cancelledEvent) {
                Log::info('Cancelled event for event id: '.$id);
                return $this->sendResponse(new EventResource($cancelledEvent), 'Event cancelled successfully.');
            } else {
                return $this->sendError('Failed to cancel event.');
            }
        } catch (Exception $e) {
            Log::error('Failed to cancel event due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to cancel event, event not found.');
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
            $event = Event::where('status', $request->get('status'))->get();
            if (count($event)) {
                Log::info('Showing events for status: '.$request->get('status'));
                return $this->sendResponse($event, 'Events retrieved successfully.');
            } else {
                return $this->sendError('Event data not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve event data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve event data, event not found.');
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
        //try {
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
        // } catch (Exception $e) {
        //     Log::error('Failed to delete event due to occurance of this exception'.'-'. $e->getMessage());
        //     return $this->sendError('Operation failed to delete event.');
        // }
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
            $events = Event::whereIn('id',explode(",",$ids))->get();
            if ($events) {
                foreach ($events as $event) {
                    if ($event->eventImages()) {
                        foreach ($event->eventImages as $file) {
                            if (file_exists(storage_path('app/'.$file->event_photo_path))) { 
                                unlink(storage_path('app/'.$file->event_photo_path));
                            }
                        }
                        $event->eventImages()->delete();
                    }
                    $event->delete();
                }
                Log::info('Selected events deleted successfully');
                return $this->sendResponse([], 'Selected events deleted successfully.');
            } else {
                return $this->sendError('Events not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete events due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete events.');
        }
    }

}
