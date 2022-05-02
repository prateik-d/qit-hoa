<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\State;
use App\Http\Requests\StoreStateRequest;
use App\Http\Resources\State as StateResource;

class StateController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $states = State::all();
            if (count($states)) {
                return $this->sendResponse(new StateResource($states), 'States retrieved successfully.');
            } else {
                return $this->sendError('No data found for states');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve states data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve states data.');
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
    public function store(StoreStateRequest $request)
    {
        try {
            $input = $request->all();
            $input['added_by'] = Auth::guard('api')->user()->id;
            $state = State::create($input);
            if ($state) {
                Log::info('State added successfully.');
                return $this->sendResponse(new StateResource($state), 'State added successfully.');
            } else {
                return $this->sendError('Failed to add state');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add state due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add state.');
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
            $state = State::findOrFail($id);
            Log::info('Showing state for state id: '.$id);
            return $this->sendResponse(new StateResource($state), 'State retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve state data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve state data, state not found.');
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
            $state = State::findOrFail($id);
            Log::info('Edit state for state id: '.$id);
            return $this->sendResponse(new StateResource($state), 'State retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit state data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit state data, state not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreStateRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $state = State::findOrFail($id);
            if ($state) {
                $update = $state->fill($input)->save();
                if ($update) {
                    Log::info('State updated successfully for state id: '.$id);
                    return $this->sendResponse(new StateResource($state), 'State updated successfully.');
                } else {
                    return $this->sendError('Failed to update state');      
                }
            } else {
                return $this->sendError('State not found');
            }
        } catch (Exception $e) {
            Log::error('Failed to update state data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update state');
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
            $message = 'State does not found! Please try again.'; 
            $state = State::findOrFail($id);
            if ($state) {
                $message = 'Cannot delete state, state is assigned to the city!';
                if (!$state->cities->count()) {
                    $state->delete();
                    Log::info('State deleted successfully for state id: '.$id);
                    return $this->sendResponse([], 'State deleted successfully.');
                }
                return $this->sendError($message);
            }
        } catch (Exception $e) {
            Log::error($message.'-'. $e->getMessage());
            return $this->sendError($message);
        }
    }
}
