<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\State;
use App\Models\City;
use App\Http\Requests\StoreCityRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $cities = City::all();
            if (count($cities)) {
                Log::info('Cities data displayed successfully.');
                return $this->sendResponse(['cities' => $cities], 'Cities data retrieved successfully.');
            } else {
                return $this->sendError('No data found for cities.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve cities data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve cities data.');
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
            $states = State::pluck('state','id');
            if (count($states)) {
                Log::info('States data displayed successfully.');
                return $this->sendResponse(['states' => $states], 'States data retrieved successfully.');
            } else {
                return $this->sendError('No data found for states.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve states data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve states data.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCityRequest $request)
    {
        try {
            $input = $request->all();
            $input['added_by'] = Auth::guard('api')->user()->id;
            $city = City::create($input);
            if ($city) {
                Log::info('City added successfully.');
                return $this->sendResponse(['city' => $city], 'City added successfully.');
            } else {
                return $this->sendError('City not found.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add city due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add city');
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
            $city = City::findOrFail($id);
            Log::info('Showing city data for city id: '.$id);
            return $this->sendResponse(['city' => $city], 'City retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve city data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve city data, city not found.');
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
            $states = State::pluck('state','id');
            $city = City::findOrFail($id);
            Log::info('Showing city data for city id: '.$id);
            return $this->sendResponse(['states'=> $states, 'city' => $city], 'City retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit city data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit city data, city not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCityRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $city = City::findOrFail($id);
            if ($city) {
                $update = $city->fill($input)->save();
                if ($update) {
                    Log::info('City updated successfully for city id: '.$id);
                    return $this->sendResponse([], 'City updated successfully.');
                } else {
                    return $this->sendError('Failed to update city.');
                }
            } else {
                return $this->sendError('City not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update city due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update city.');
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
            $city = City::find($id);
            if ($city) {
                $city->delete();
                Log::info('City deleted successfully for city id: '.$id);
                return $this->sendResponse([], 'City deleted successfully.');
            } else {
                return $this->sendError('City not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete city due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete city.');
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
            $ids = $request->id;
            $cities = City::whereIn('id',explode(",",$ids))->delete();
            if ($cities) {
                Log::info('Selected cities deleted successfully');
                return $this->sendResponse([], 'Selected cities deleted successfully.');
            } else {
                return $this->sendError('Cities not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete cities due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete cities.');
        }
    }
}
