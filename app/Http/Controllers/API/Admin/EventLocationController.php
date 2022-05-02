<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\EventLocation;
use App\Http\Requests\StoreEventLocationRequest;
use App\Http\Resources\EventLocation as EventLocationResource;

class EventLocationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $eventCategories = EventLocation::all();
            if (count($eventCategories)) {
                Log::info('Event categories data displayed successfully.');
                return $this->sendResponse(EventLocationResource::collection($eventCategories), 'Event categories data retrieved successfully.');
            } else {
                return $this->sendError('No data found for event categories.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve event categories due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Failed to retrieve event categories.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventLocationRequest $request)
    {
        try {
            $input = $request->all();
            $input['added_by'] = Auth::guard('api')->user()->id;
            $eventLocation = EventLocation::create($input);
            if ($eventLocation) {
                Log::info('Event-Location added successfully.');
                return $this->sendResponse(new EventLocationResource($eventLocation), 'Event-Location added successfully.');
            } else {
                return $this->sendError('Failed to add event-Location.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add event-category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add event-category');
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
            $eventLocation = EventLocation::findOrFail($id);
            Log::info('Showing event-Location for Location id: '.$id);
            return $this->sendResponse(new EventLocationResource($eventLocation), 'Event-Location retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve event-Location due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve event-Location data, Location not found.');
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
            $eventLocation = EventLocation::findOrFail($id);
            Log::info('Showing event-Location for Location id: '.$id);
            return $this->sendResponse(new EventLocationResource($eventLocation), 'Event-Location retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit event-Location due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit event-Location data, Location not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEventLocationRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $eventLocation = EventLocation::findOrFail($id);
            if ($eventLocation) {
                $update = $eventLocation->fill($input)->save();
                if ($update) {
                    Log::info('Event-Location updated successfully for Location id: '.$id);
                    return $this->sendResponse(new EventLocationResource($eventLocation), 'Event-Location updated successfully.');
                } else {
                    return $this->sendError('Failed to update event-Location.');     
                }
            } else {
                return $this->sendError('Event-Location not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update event-Location due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update event-Location.');
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
            $message = 'Event-Location does not found! Please try again.'; 
            $eventLocation = EventLocation::findOrFail($id);
            if ($eventLocation) {
                $message = 'Cannot delete event-Location, event-Location is assigned to the event!';
                if (!$eventLocation->events->count()) {
                    $eventLocation->delete();
                    Log::info('Event-Location deleted successfully for Location id: '.$id);
                    return $this->sendResponse([], 'Event-Location deleted successfully.');
				}
                return $this->sendError($message);
            }
        } catch (Exception $e) {
            Log::error($message.'-'. $e->getMessage());
            return $this->sendError($message);
        }
    }
}
