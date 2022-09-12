<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\EventCategory;
use App\Http\Requests\StoreEventCategoryRequest;
use App\Http\Resources\EventCategory as EventCategoryResource;

class EventCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $eventCategories = EventCategory::all();
            if (count($eventCategories)) {
                Log::info('Event categories data displayed successfully.');
                return $this->sendResponse(['eventCategories' => $eventCategories], 'Event categories data retrieved successfully.');
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
    public function store(StoreEventCategoryRequest $request)
    {
        try {
            $input = $request->all();
            $input['added_by'] = Auth::guard('api')->user()->id;
            $eventCategory = EventCategory::create($input);
            if ($eventCategory) {
                Log::info('Event-category added successfully.');
                return $this->sendResponse(new EventCategoryResource($eventCategory), 'Event-category added successfully.');
            } else {
                return $this->sendError('Failed to add event-category.');     
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
            $eventCategory = EventCategory::findOrFail($id);
            Log::info('Showing event-category for category id: '.$id);
            return $this->sendResponse(['eventCategory' => $eventCategory], 'Event-category retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve event-category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve event-category data, category not found.');
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
            $eventCategory = EventCategory::findOrFail($id);
            Log::info('Showing event-category for category id: '.$id);
            return $this->sendResponse(['eventCategory' => $eventCategory], 'Event-category retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit event-category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit event-category data, category not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEventCategoryRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $eventCategory = EventCategory::findOrFail($id);
            if ($eventCategory) {
                $update = $eventCategory->fill($input)->save();
                if ($update) {
                    Log::info('Event-category updated successfully for category id: '.$id);
                    return $this->sendResponse(new EventCategoryResource($eventCategory), 'Event-category updated successfully.');
                } else {
                    return $this->sendError('Failed to update event-category.');     
                }
            } else {
                return $this->sendError('Event-category not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update event-category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update event-category.');
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
            $message = 'Event-category does not found! Please try again.'; 
            $eventCategory = EventCategory::findOrFail($id);
            if ($eventCategory) {
                $message = 'Cannot delete event-category, event-category is assigned to the event!';
                if (!$eventCategory->events->count()) {
                    $eventCategory->delete();
                    Log::info('Event-category deleted successfully for category id: '.$id);
                    return $this->sendResponse([], 'Event-category deleted successfully.');
				}
                return $this->sendError($message);
            }
        } catch (Exception $e) {
            Log::error($message.'-'. $e->getMessage());
            return $this->sendError($message);
        }
    }
}
