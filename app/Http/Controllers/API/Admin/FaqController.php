<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Faq;
use App\Http\Resources\Faq as FaqResource;
use App\Http\Requests\StoreFaqRequest;

class FaqController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $faq = Faq::all();
            if (count($faq)) {
                Log::info('Faq data displayed successfully.');
                return $this->sendResponse(FaqResource::collection($faq), 'Faq data retrieved successfully.');
            } else {
                return $this->sendError('No data found for faq.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve faq data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve faq data.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFaqRequest $request)
    {
        try {
            $input = $request->all();
            $input['added_by'] = Auth::guard('api')->user()->id;
            $faq = Faq::create($input);
            if ($faq) {
                Log::info('Faq added successfully.');
                return $this->sendResponse(new FaqResource($faq), 'Faq added successfully.');
            } else {
                return $this->sendError('Failed to add faq.');   
            }
        } catch (Exception $e) {
            Log::error('Failed to add faq due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add faq.');
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
            $faq = Faq::findOrFail($id);
            Log::info('Showing faq data for faq id: '.$id);
            return $this->sendResponse(new FaqResource($faq), 'Faq retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve faq data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve faq data, faq not found.');
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
            $faq = Faq::findOrFail($id);
            Log::info('Edit faq data for faq id: '.$id);
            return $this->sendResponse(new FaqResource($faq), 'Faq retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit faq data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit faq data, faq not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFaqRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $faq = Faq::findOrFail($id);
            if ($faq) {
                $update = $faq->fill($input)->save();
                if ($update) {
                    Log::info('Faq updated successfully for faq id: '.$id);
                    return $this->sendResponse([], 'Faq updated successfully.');
                } else {
                    return $this->sendError('Failed to update faq');      
                }
            } else {
                return $this->sendError('Faq not found.');   
            }
        } catch (Exception $e) {
            Log::error('Failed to update faq due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update faq.');
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
            $faq = Faq::findOrFail($id);
            if ($faq) {
                if ($faq->delete()) {
                    Log::info('Faq deleted successfully for faq id: '.$id);
                    return $this->sendResponse([], 'Faq deleted successfully.');
                } else {
                    return $this->sendError('Faq can not be deleted.');
                }
            } else {
                return $this->sendError('Faq not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete faq due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete faq.');
        }
    }
}
