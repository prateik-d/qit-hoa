<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Http\Resources\Document as DocumentResource;
use App\Http\Requests\StoreDocumentRequest;

class DocumentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $document = Document::where('title', 'LIKE', '%'.$request->get('title'). '%')
                ->where('type', 'LIKE', '%'.$request->get('type'). '%')
                ->where('year', 'LIKE', '%'.$request->get('year'). '%')->get();

            if (count($document)) {
                Log::info('Document data displayed successfully.');
                return $this->sendResponse(new DocumentResource($document), 'Document data retrieved successfully.');
            } else {
                return $this->sendError('No data found for document.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve document data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve document data.');
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
            $categories = DocumentCategory::orderBy('title','asc')->pluck('title', 'id');
            Log::info('Document categories displayed successfully.');
            return $this->sendResponse($categories, 'Document categories retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve document categories due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve document categories.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocumentRequest $request)
    {
        try {
            $input = $request->all();
            $input['added_by'] = Auth::guard('api')->user()->id;
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $name = $file->getClientOriginalName();
                $filename = $input['title'].'-'.$name;
                $path = $file->storeAs('public/documents', $filename);
                $input['file_path'] = $path;
            }
            $document = Document::create($input);
            if($document) {
                Log::info('Document added successfully.');
                return $this->sendResponse(new DocumentResource($document), 'Document added successfully.');
            } else {
                return $this->sendError('Failed to add document');      
            }
        } catch (Exception $e) {
            Log::error('Failed to add document due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add document.');
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
            $document = Document::findOrFail($id);
            Log::info('Showing document data for document id: '.$id);
            return $this->sendResponse(new DocumentResource($document), 'Document retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve document data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve document data, document not found.');
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
            $document = Document::findOrFail($id);
            Log::info('Edit document data for document id: '.$id);
            return $this->sendResponse(new DocumentResource($document), 'Document retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit document data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit document data, document not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDocumentRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $document = Document::findOrFail($id);
            if ($document) {
                if ($request->hasFile('document')) {
                    if ($document->file_path != null) {
                        if (file_exists(storage_path('app/'.$document->file_path))) {
                            unlink(storage_path('app/'.$document->file_path));
                        }
                    }
                    $file = $request->file('document');
                    $name = $file->getClientOriginalName();
                    $filename = $input['title'].'-'.$name;
                    $path = $file->storeAs('public/documents', $filename);
                    $input['file_path'] = $path;
                }
                $updated = $document->fill($input)->save();
                if ($updated) {
                    Log::info('Document updated successfully for document id: '.$id);
                    return $this->sendResponse([], 'Document updated successfully.');
                } else {
                    return $this->sendError('Failed to update document');      
                }
            } else {
                return $this->sendError('Document not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update document due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update document.');
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
            $document = Document::findOrFail($id);
            if ($document) {
                if ($document->file_path != null) {
                    if (file_exists(storage_path('app/'.$document->file_path))) {
                        unlink(storage_path('app/'.$document->file_path));
                    }
                }
                $document->delete();
                Log::info('Document deleted successfully for document id: '.$id);
                return $this->sendResponse([], 'Document deleted successfully.');
            } else {
                return $this->sendError('Document not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete document due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete document.');
        }
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
            $documents = Document::whereIn('id',explode(",",$ids))->get();
            if ($documents) {
                foreach ($documents as $document) {
                    if ($document->file_path != null) {
                        if (file_exists(storage_path('app/'.$document->file_path))) {
                            unlink(storage_path('app/'.$document->file_path));
                        }
                    }
                    $document->delete();
                }
                Log::info('Selected documents deleted successfully');
                return $this->sendResponse([], 'Selected documents deleted successfully.');
            } else {
                return $this->sendError('Documents not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete documents due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete documents.');
        }
    }
}
