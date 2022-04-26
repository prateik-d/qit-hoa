<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\PetType;
use App\Http\Resources\PetType as PetTypeResource;
use App\Http\Requests\StorePetTypeRequest;

class PetTypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $petType = PetType::all();
            if (count($faq)) {
                Log::info('Pet-type data displayed successfully.');
                return $this->sendResponse(PetTypeResource::collection($petType), 'Pet-type data retrieved successfully.');
            } else {
                return $this->sendError('No data found for pet-type.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve pet-type data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve pet-type data.');
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
    public function store(StorePetTypeRequest $request)
    {
        try {
            $input = $request->all();
            $petType = PetType::create($input);
            if ($petType) {
                Log::info('Pet-type added successfully.');
                return $this->sendResponse(new PetTypeResource($petType), 'Pet-type added successfully.');
            } else {
                return $this->sendError('Failed to add pet-type');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add pet-type due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add pet-type.');
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
            $petType = PetType::findOrFail($id);
            Log::info('Showing pet-type data for pet-type id: '.$id);
            return $this->sendResponse(new PetTypeResource($petType), 'pet-type retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve pet-type data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve pet-type data, pet-type not found.');
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
            $petType = PetType::findOrFail($id);
            Log::info('Edit pet-type data for pet-type id: '.$id);
            return $this->sendResponse(new PetTypeResource($petType), 'pet-type retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit pet-type data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit pet-type data, pet-type not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePetTypeRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $petType = PetType::findOrFail($id);
            if ($petType) {
                $update = $petType->fill($input)->save();
                if ($update) {
                    Log::info('Pet-type updated successfully for pet-type id: '.$id);
                    return $this->sendResponse([], 'Pet-type updated successfully.');
                } else {
                    return $this->sendError('Failed to update pet-type.');      
                }
            } else {
                return $this->sendError('Pet-type not found.');   
            }
        } catch (Exception $e) {
            Log::error('Failed to update pet-type data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update pet-type.');
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
            $petType = PetType::findOrFail($id);
            if ($petType) {
                if ($petType->delete()) {
                    return $this->sendResponse([], 'Pet-type deleted successfully.');
                } else {
                    return $this->sendError('Pet-type can not be deleted.');
                }
            } else {
                return $this->sendError('Pet-type not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete pet-type due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete pet-type.');
        }
    }
}
