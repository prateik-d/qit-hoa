<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Violation;
use App\Http\Resources\Violation as ViolationResource;
use App\Http\Requests\StoreViolationRequest;

class ViolationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $violations = Violation::all();
            if (count($ticket)) {
                Log::info('Violations data displayed successfully.');
                return $this->sendResponse(ViolationResource::collection($violations), 'Violations data retrieved successfully.');
            } else {
                return $this->sendError('No data found for violations');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve violations data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve violations data.');
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
    public function store(StoreViolationRequest $request)
    {
        try {
            $input = $request->all();
            $input['approved_by'] = Auth::guard('api')->user()->id;
            $violation = Violation::create($input);
            if ($violation) {
                Log::info('Violation added successfully.');
                return $this->sendResponse(new ViolationResource($violation), 'Violation added successfully.');
            } else {
                return $this->sendError('Failed to add violation');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add violation due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add violation.');
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
            $violation = Violation::findOrFail($id);
            Log::info('Showing violation data for violation id: '.$id);
            return $this->sendResponse(new ViolationResource($violation), 'Violation retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve violation data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve violation data, violation not found.');
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
            $violation = Violation::findOrFail($id);
            Log::info('Edit violation data for violation id: '.$id);
            return $this->sendResponse(new ViolationResource($violation), 'Violation retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit violation data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit violation data, violation not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreViolationRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $violation = Violation::findOrFail($id);
            if ($violation) {
                $updated = $violation->fill($input)->save();
                if ($updated) {
                    Log::info('Violation updated successfully for violation id: '.$id);
                    return $this->sendResponse(new ViolationResource($violation), 'Violation updated successfully.');
                } else {
                    return $this->sendError('Failed to update violation.');      
                }
            } else {
                return $this->sendError('Violation not found to update');
            }
        } catch (Exception $e) {
            Log::error('Failed to update violation due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update violation.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Violation $violation)
    {
        try {
            $violation = Violation::findOrFail($id);
            if ($violation) {
                if ($violation->delete()) {
                    Log::info('Violation deleted successfully for pet id: '.$id);
                    return $this->sendResponse([], 'Violation deleted successfully.');
                } else {
                    return $this->sendError('Violation can not be deleted.');
                }
            } else {
                return $this->sendError('Violation not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete violation due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete violation.');
        }
    }
}
