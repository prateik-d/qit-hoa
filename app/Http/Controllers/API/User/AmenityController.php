<?php

namespace App\Http\Controllers\API\User;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Amenity;
use App\Models\AmenityDocument;
use App\Http\Requests\StoreAmenityRequest;
use App\Http\Resources\Amenity as AmenityResource;

class AmenityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $amenities = Amenity::with('amenityDocuments')->where('title', 'LIKE', '%'.$request->get('title'). '%')->get();
            if (count($amenities)) {
                Log::info('Displayed amenities data successfully.');
                return $this->sendResponse(new AmenityResource($amenities), 'Amenity retrieved successfully.');
            } else {
                return $this->sendError('No data found for amenities data.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve amenities data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve amenities data.');
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
    public function store(Request $request)
    {
        //
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
            $amenity = Amenity::with('amenityDocuments')->findOrFail($id);
            Log::info('Showing amenity for amenity id: '.$id);
            return $this->sendResponse(new AmenityResource($amenity), 'Amenity retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve amenity due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve amenity, amenity not found.');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
