<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Breed;
use App\Http\Requests\StoreBreedRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BreedController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $breeds = Breed::all();
            if (count($breeds)) {
                Log::info('Displayed breeds data successfully');
                return $this->sendResponse($breeds, 'Breeds data retrieved successfully.');
            } else {
                return $this->sendError('No data found for breeds.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve breeds data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve breeds data.');
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
    public function store(StoreBreedRequest $request)
    {
        try {
            $input = $request->all();
            $input['added_by'] = Auth::guard('api')->user()->id;
            $breed = Breed::create($input);
            if ($breed) {
                Log::info('Breed added successfully.');
                return $this->sendResponse($breed, 'Breed added successfully.');
            } else {
                return $this->sendError('Failed to add breed.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add breed due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add breed.');
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
            $breed = Breed::findOrFail($id);
            Log::info('Showing breed for category id: '.$id);
            return $this->sendResponse($breed, 'Breed retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve breed due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve breed, breed not found.');
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
            $breed = Breed::findOrFail($id);
            Log::info('Showing breed for category id: '.$id);
            return $this->sendResponse($breed, 'Breed retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit breed due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit breed, breed not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBreedRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $breed = Breed::findOrFail($id);
            if ($breed) {
                $update = $breed->fill($input)->save();
                if ($update) {
                    Log::info('Breed updated successfully for breed id: '.$id);
                    return $this->sendResponse($breed, 'Breed updated successfully.');
                } else {
                    return $this->sendError('Failed to update breed.');
                }
            } else {
                return $this->sendError('Breed not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to add breed due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update breed.');
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
            $breed = Breed::findOrFail($id);
            if ($breed) {
                $breed->delete();
                Log::info('Breed deleted successfully for breed id: '.$id);
                return $this->sendResponse([], 'Breed deleted successfully.');
            } else {
                return $this->sendError('Breed not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete breed due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete breed.');
        }
    }
}
