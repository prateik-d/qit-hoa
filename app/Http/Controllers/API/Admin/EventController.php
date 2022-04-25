<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
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
            if($event) {
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
                $updated = $event->fill($input)->save();
                if ($updated) {
                    Log::info('Event updated successfully for event id: '.$id);
                    return $this->sendResponse(new EventResource($event), 'Event updated successfully.');
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
                if ($event->delete()) {
                    return $this->sendResponse([], 'Event deleted successfully.');
                } else {
                    return $this->sendError('Failed to delete event.');
                }
            } else {
                return $this->sendError('Event not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete event due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete event.');
        }
    }
}
