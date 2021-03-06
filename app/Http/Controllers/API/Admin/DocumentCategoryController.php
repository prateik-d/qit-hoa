<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\DocumentCategory;
use App\Http\Requests\StoreDocumentCategoryRequest;
use App\Http\Resources\DocumentCategory as DocumentCategoryResource;

class DocumentCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $documentCategories = DocumentCategory::all();
            if (count($documentCategories)) {
                Log::info('Document categories data displayed successfully.');
                return $this->sendResponse(new DocumentCategoryResource($documentCategories), 'Document categories data retrieved successfully.');
            } else {
                return $this->sendError('No data found for document categories.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve document categories due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Failed to retrieve document categories.');
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
    public function store(StoreDocumentCategoryRequest $request)
    {
        try {
            $input = $request->all();
            $input['added_by'] = Auth::guard('api')->user()->id;
            $documentCategory = DocumentCategory::create($input);
            if ($documentCategory) {
                Log::info('Document category added successfully.');
                return $this->sendResponse(new DocumentCategoryResource($documentCategory), 'Document category added successfully.');
            } else {
                return $this->sendError('Failed to add document category.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add document category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add document category');
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
            $documentCategory = DocumentCategory::findOrFail($id);
            Log::info('Showing document category for category id: '.$id);
            return $this->sendResponse(new DocumentCategoryResource($documentCategory), 'Document category retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve document category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve document category data, category not found.');
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
            $documentCategory = DocumentCategory::findOrFail($id);
            Log::info('Showing document category for category id: '.$id);
            return $this->sendResponse(new DocumentCategoryResource($documentCategory), 'Document category retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit document category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit document category data, category not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDocumentCategoryRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $documentCategory = DocumentCategory::findOrFail($id);
            if ($documentCategory) {
                $update = $documentCategory->fill($input)->save();
                if ($update) {
                    Log::info('Document category updated successfully for category id: '.$id);
                    return $this->sendResponse(new DocumentCategoryResource($documentCategory), 'Document category updated successfully.');
                } else {
                    return $this->sendError('Failed to update document category.');     
                }
            } else {
                return $this->sendError('Document category not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update document category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update document category.');
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
            $message = 'Document category does not found! Please try again.'; 
            $documentCategory = DocumentCategory::findOrFail($id);
            if ($documentCategory) {
                $message = 'Cannot delete document-category, document-category is assigned to the document!';
                if (!$documentCategory->documents->count()) {
                    $documentCategory->delete();
                    Log::info('Document category deleted successfully for category id: '.$id);
                    return $this->sendResponse([], 'Document category deleted successfully.');
				}
                return $this->sendError($message);
            }
        } catch (Exception $e) {
            Log::error($message.'-'. $e->getMessage());
            return $this->sendError($message);
        }
    }
}
