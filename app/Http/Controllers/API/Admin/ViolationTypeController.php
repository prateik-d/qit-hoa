<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ViolationType;
use App\Http\Requests\StoreViolationTypeRequest;

class ViolationTypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $violationTypes = ViolationType::all();
            if (count($violationTypes)) {
                Log::info('Violation-type data displayed successfully.');
                return $this->sendResponse(ViolationTypeResource::collection($violationTypes), 'Violation-type data retrieved successfully.');
            } else {
                return $this->sendError('No data found for violation-type.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve violation-type data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve violation-type data.');
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
    public function store(StoreViolationTypeRequest $request)
    {
        try {
            $input = $request->all();
            $violationType = ViolationType::create($input);
            if ($violationType) {
                Log::info('Violation-type added successfully.');
                return $this->sendResponse(new ViolationTypeResource($violationType), 'Violation-type added successfully.');
            } else {
                return $this->sendError('Failed to add violation-type');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add violation-type due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add violation-type.');
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
            $violationType = ViolationType::findOrFail($id);
            Log::info('Showing violation-type data for violation-type id: '.$id);
            return $this->sendResponse(new ViolationTypeResource($violationType), 'violation-type retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve violation-type data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve violation-type data, violation-type not found.');
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
            $violationType = ViolationType::findOrFail($id);
            Log::info('Edit violation-type data for violation-type id: '.$id);
            return $this->sendResponse(new ViolationTypeResource($violationType), 'violation-type retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit violation-type data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit violation-type data, violation-type not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreViolationTypeRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $violationType = ViolationType::findOrFail($id);
            if ($violationType) {
                $update = $violationType->fill($input)->save();
                if ($update) {
                    Log::info('Violation-type updated successfully for violation-type id: '.$id);
                    return $this->sendResponse([], 'Violation-type updated successfully.');
                } else {
                    return $this->sendError('Failed to update violation-type.');      
                }
            } else {
                return $this->sendError('Violation-type not found.');   
            }
        } catch (Exception $e) {
            Log::error('Failed to update violation-type data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update violation-type.');
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
            $violationType = ViolationType::findOrFail($id);
            if ($violationType) {
                if ($violationType->delete()) {
                    return $this->sendResponse([], 'Violation-type deleted successfully.');
                } else {
                    return $this->sendError('Violation-type can not be deleted.');
                }
            } else {
                return $this->sendError('Violation-type not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete violation-type due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete violation-type.');
        }
    }
}
