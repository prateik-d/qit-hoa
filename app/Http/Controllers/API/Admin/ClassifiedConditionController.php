<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ClassifiedCondition;
use App\Http\Requests\StoreClassifiedConditionRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClassifiedConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $classifiedConditions = Classifiedcondition::all();
            if (count($classifiedConditions)) {
                Log::info('Classified conditions data displayed successfully.');
                return $this->sendResponse($classifiedConditions, 'Classified conditions data retrieved successfully.');
            } else {
                return $this->sendError('No data found for classified conditions.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieved classified conditions due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieved classified conditions.');
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
    public function store(StoreClassifiedConditionRequest $request)
    {
        try {
            $input = $request->all();
            $input['added_by'] = Auth::guard('api')->user()->id;
            $classifiedCondition = Classifiedcondition::create($input);
            if ($classifiedCondition) {
                Log::info('Classified condition added successfully.');
                return $this->sendResponse($classifiedCondition, 'Classified condition added successfully.');
            } else {
                return $this->sendError('Failed to add classified condition.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add classified condition due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add classified condition.');
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
            $classifiedCondition = Classifiedcondition::findOrFail($id);
            Log::info('Showing classified condition for condition id: '.$id);
            return $this->sendResponse($classifiedCondition, 'Classified condition retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve classified condition due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve classified condition, condition not found.');
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
            $classifiedCondition = Classifiedcondition::findOrFail($id);
            Log::info('Showing classified condition for condition id: '.$id);
            return $this->sendResponse($classifiedCondition, 'Classified condition retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit classified condition due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit classified condition, condition not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $classifiedCondition = Classifiedcondition::findOrFail($id);
            if ($classifiedCondition) {
                $update = $classifiedCondition->fill($input)->save();
                if ($update) {
                    Log::info('Classified condition updated successfully for condition id: '.$id);
                    return $this->sendResponse($classifiedCondition, 'Classified condition updated successfully.');
                } else {
                    return $this->sendError('Failed to update classified condition.');
                }
            } else {
                return $this->sendError('Classified condition not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update classified condition due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update classified condition.');
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
            $classifiedCondition = Classifiedcondition::findOrFail($id);
            if ($classifiedCondition) {
                $classifiedCondition->delete();
                Log::info('Classified condition deleted successfully for condition id: '.$id);
                return $this->sendResponse([], 'Classified condition deleted successfully.');
            } else {
                return $this->sendError('Classified condition not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete classified condition due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete classified condition');
        }
    }
}
