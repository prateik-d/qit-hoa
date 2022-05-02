<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ClassifiedCategory;
use App\Http\Requests\StoreClassifiedCategoryRequest;
use App\Http\Resources\ClassifiedCategory as ClassifiedCategoryResource;

class ClassifiedCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $classifiedCategories = ClassifiedCategory::all();
            if (count($classifiedCategories)) {
                Log::info('Classified categories data displayed successfully.');
                return $this->sendResponse(new ClassifiedCategoryResource($classifiedCategories), 'Classified categories data retrieved successfully.');
            } else {
                return $this->sendError('No data found for classified categories.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve classified categories data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve classified categories data.');
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
    public function store(StoreClassifiedCategoryRequest $request)
    {
        try {
            $input = $request->all();
            $input['added_by'] = Auth::guard('api')->user()->id;
            $classifiedCategory = ClassifiedCategory::create($input);
            if ($classifiedCategory) {
                Log::info('Classified category added successfully.');
                return $this->sendResponse(new ClassifiedCategoryResource($classifiedCategory), 'Classified category added successfully.');
            } else {
                return $this->sendError('Failed to add classified category.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add classified category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add classified category.');
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
            $classifiedCategory = ClassifiedCategory::findOrFail($id);
            Log::info('Showing classified category for category id: '.$id);
            return $this->sendResponse(new ClassifiedCategoryResource($classifiedCategory), 'Classified category retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve classified category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve classified category, Category not found.');
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
            $classifiedCategory = ClassifiedCategory::findOrFail($id);
            Log::info('Showing classified category for category id: '.$id);
            return $this->sendResponse(new ClassifiedCategoryResource($classifiedCategory), 'Classified category retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit classified category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit classified category, Category not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreClassifiedCategoryRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $classifiedCategory = ClassifiedCategory::findOrFail($id);
            if ($classifiedCategory) {
                $update = $classifiedCategory->fill($input)->save();
                if ($update) {
                    Log::info('Classified category updated successfully for category id: '.$id);
                    return $this->sendResponse(new ClassifiedCategoryResource($classifiedCategory), 'Classified category updated successfully.');
                } else {
                    return $this->sendError('Failed to update classified category.');
                }
            } else {
                return $this->sendError('Classified category not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update classified category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update classified category.');
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
            $message = 'Classified-category does not found! Please try again.'; 
            $classifiedCategory = ClassifiedCategory::findOrFail($id);
            if ($classifiedCategory) {
                if (!$classifiedCategory->classifiedItems->count()) {
                    $classifiedCategory->delete();
                    Log::info('Classified category deleted successfully for category id: '.$id);
                    return $this->sendResponse([], 'Classified category deleted successfully.');
                } else {
                    $message = 'Cannot delete classified-category, classified-category is assigned to the classified!';
                }
                return $this->sendError($message);
            }
        } catch (Exception $e) {
            Log::error($message.'-'. $e->getMessage());
            return $this->sendError($message);
        }
    }
}
