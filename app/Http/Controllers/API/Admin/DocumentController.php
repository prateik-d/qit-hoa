<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Document;
use App\Models\DocumentFile;
use App\Models\DocumentCategory;
use App\Models\User;
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
            $document = Document::where('title', 'LIKE', '%'.$request->get('title'). '%');
            
            if ($request->type && $request->year) {
                $document = $document->where('type', $request->get('type'))->where('year', $request->get('year'));
            } else if ($request->type) {
                $document = $document->where('type', $request->get('type'));
            } else if ($request->year) {
                $document = $document->where('year', $request->get('year'));
            }

            $document = $document->get();

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
    public function create(Request $request)
    {
        try {
            $categories = DocumentCategory::orderBy('title','asc')->pluck('title', 'id');
            $users = User::where('status', 1)->where('first_name', 'LIKE' , '%'.$request->get('name').'%')
            ->where('last_name', 'LIKE' , '%'.$request->get('name').'%')
            ->where('address', 'LIKE' , '%'.$request->get('address').'%')
            ->where('email', 'LIKE' , '%'.$request->get('email').'%')
            ->where('mobile_no', 'LIKE' , '%'.$request->get('phone').'%')->get();

            if (count($categories) && count($users)) {
                Log::info('Document categories displayed successfully.');
                return $this->sendResponse(['categories' => $categories, 'users' =>  $users], 'Document categories retrieved successfully.');
            } else {
                return $this->sendError('No data found for document categories.');
            }
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
            // if ($request->hasFile('document')) {
            //     $file = $request->file('document');
            //     $name = $file->getClientOriginalName();
            //     $filename = $input['title'].'-'.$name;
            //     $path = $file->storeAs('public/documents', $filename);
            //     $input['file_path'] = $path;
            // }
            $document = Document::create($input);
            if ($document) {
                if ($request->hasFile('document')) {
                    $folder = 'documents';
                    $input = $request->document;
                    $files = $request->file('document');
                    $this->fileUpload($folder, $input, $files, $document);
                }
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
     * File upload for Pet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileUpload($folder, $input, $files, $document)
    {
        try {
            $allowedfileExtension = ['pdf','jpg','jpeg','png','xlsx'];
            foreach ($files as $file) {      
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if($check) {
                    foreach((array)$input as $mediaFiles) {
                        $name = $mediaFiles->getClientOriginalName();
                        $filename = $document->id.'-'.$name;
                        $path = $mediaFiles->storeAs('public/'.$folder, $filename);
                        $ext  =  $mediaFiles->getClientOriginalExtension();
                        //store document file into directory and db
                        $documentFiles = new documentFile();
                        $documentFiles->document_id = $document->id;
                        $documentFiles->file_path = $path;
                        $documentFiles->save();
                    }
                } else {
                    return $this->sendError('invalid_file_format'); 
                }
                Log::info('File uploaded successfully.');
                return response()->json(['file uploaded'], 200);
            }
        } catch (Exception $e) {
            Log::error('Failed to upload document files due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to upload document files.');
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
            $document = Document::find($id);
            if ($document) {
                Log::info('Showing document data for document id: '.$id);
                return $this->sendResponse(new DocumentResource($document), 'Document retrieved successfully.');
            } else {
                return $this->sendError('Document data not found.');     
            }
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
            $document = Document::find($id);
            if ($document) {
                Log::info('Edit document data for document id: '.$id);
                return $this->sendResponse(new DocumentResource($document), 'Document retrieved successfully.');
            } else {
                return $this->sendError('Document data not found.');     
            }
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
            $document = Document::find($id);
            if ($document) {
                // if ($request->hasFile('document')) {
                //     if ($document->file_path != null) {
                //         if (file_exists(storage_path('app/'.$document->file_path))) {
                //             unlink(storage_path('app/'.$document->file_path));
                //         }
                //     }
                //     $file = $request->file('document');
                //     $name = $file->getClientOriginalName();
                //     $filename = $input['title'].'-'.$name;
                //     $path = $file->storeAs('public/documents', $filename);
                //     $input['file_path'] = $path;
                // }
                $update = $document->fill($input)->save();
                if ($update) {
                    if ($request->hasFile('document')) {
                        // Delete old documents to upload new
                        if ($document->documentFiles()) {
                            foreach ($document->documentFiles as $file) {
                                if (file_exists(storage_path('app/'.$file->file_path))) { 
                                    unlink(storage_path('app/'.$file->file_path));
                                }
                            }
                            $document->documentFiles()->delete();
                        }
                        // Add new documents
                        $folder = 'documents';
                        $input = $request->document;
                        $files = $request->file('document');
                        $this->fileUpload($folder, $input, $files, $document);
                    }
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function filterByType(Request $request)
    {
        try {
            $document = Document::where('type', $request->get('type'))->get();
            
            if (count($document)) {
                Log::info('Showing documents for type: '.$request->get('type'));
                return $this->sendResponse($document, 'Documents retrieved successfully.');
            } else {
                return $this->sendError('Documents data not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve documents data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve documents data, documents not found.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function filterByYear(Request $request)
    {
        try {
            $document = Document::where('year', $request->get('year'))->get();
            
            if (count($document)) {
                Log::info('Showing documents for year: '.$request->get('year'));
                return $this->sendResponse($document, 'Documents retrieved successfully.');
            } else {
                return $this->sendError('Documents data not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve documents data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve documents data, documents not found.');
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
            $document = Document::find($id);
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
