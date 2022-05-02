<?php

namespace App\Http\Controllers\API\User;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Vehicle;
use App\Models\VehicleColor;
use App\Models\VehicleDocument;
use App\Models\VehicleModel;
use App\Models\VehicleMake;
use App\Models\User;
use App\Http\Resources\Vehicle as VehicleResource;
use App\Http\Requests\StoreVehicleRequest;
use Notification;
use App\Notifications\NewVehicleNotification;

class VehicleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $vehicles = Auth::guard('api')->user()->vehicles;

            if (count($vehicles)) {
                Log::info('Vehicle data displayed successfully.');
                return $this->sendResponse(VehicleResource::collection($vehicles), 'Vehicle data retrieved successfully.');
            } else {
                return response()->json(['Result' => 'No Data not found'], 404);
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve vehicles data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve vehicles data.');
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
            $vehicleMakes = VehicleMake::where('status', 1)
                            ->orderBy('make', 'ASC')
                            ->get();
            $vehicleModels = VehicleModel::where('status', 1)
                            ->orderBy('model', 'ASC')
                            ->get();
            $vehicleColors = VehicleColor::where('status', 1)
                            ->orderBy('color', 'ASC')
                            ->get();

            if (count($vehicleMakes) && count($vehicleModels) && count($vehicleColors)) {
                Log::info('Vehicle-makes data, vehicle-models and vehicle-colors data displayed successfully.');
                return $this->sendResponse([$vehicleMakes, $vehicleModels], 'Vehicle-makes data, vehicle-models and vehicle-colors data displayed successfully.');
            } else {
                return $this->sendError('No data found for vehicle-makes, vehicle-models and vehicle-colors.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve vehicle-makes, vehicle-models and vehicle-colors data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve vehicle-makes, vehicle-models and vehicle-colors data.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicleRequest $request)
    {
        try {
            $input = $request->all();
            $admins = User::whereHas('role', function ($query) {
                $query->where('id', 1);
            })->get();

            $input['owner_id'] = Auth::guard('api')->user()->id;
            // Need Access toll tags
            if ($input['access_toll_tags_needed'] == 1) {
                $input['access_toll_tags_needed'] = 'yes';
            } else {
                $input['access_toll_tags_needed'] = 'no';
            }
            // Need Stickers
            if ($input['stickers_needed'] == 1) {
                $input['stickers_needed'] = 'yes';
            } else {
                $input['stickers_needed'] = 'no';
            }
            $vehicle = Vehicle::create($input);
            if($vehicle) {
                if ($request->hasFile('vehicle_document')) {
                    $file = $request->file('vehicle_document');
                    $name = $file->getClientOriginalName();
                    $filename = $vehicle->id.'-'.$name;
                    $path = $file->storeAs('public/vehicle_documents', $filename);
                    //store image file into directory and db
                    $vehicleDocument = new VehicleDocument();
                    $vehicleDocument->vehicle_id = $vehicle->id;
                    $vehicleDocument->file_type = $input['document_type'];
                    $vehicleDocument->file_path = $path;
                    $vehicleDocument->status = 1;
                    $vehicleDocument->save();
                }
                Notification::send($admins, new NewVehicleNotification($vehicle));
                Log::info('Vehicle added successfully.');
                return $this->sendResponse(new VehicleResource($vehicle), 'Vehicle created successfully.');
            } else {
                return $this->sendError('Failed to add vehicle.');   
            }
        } catch (Exception $e) {
            Log::error('Failed to add vehicle due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add vehicle.');
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
            $vehicle = Auth::guard('api')->user()->vehicles->find($id);
            Log::info('Showing vehicle data for vehicle id: '.$id);
            return $this->sendResponse(new VehicleResource($vehicle), 'Vehicle retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve vehicle data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve vehicle data, vehicle not found.');
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
            $vehicle = Auth::guard('api')->user()->vehicles->find($id);
            Log::info('Edit vehicle data for vehicle id: '.$id);
            return $this->sendResponse(new VehicleResource($vehicle), 'Vehicle retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit vehicle data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit vehicle data, vehicle not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreVehicleRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $input['owner_id'] = Auth::guard('api')->user()->id;
            // Need Access toll tags
            if ($input['access_toll_tags_needed'] == 1) {
                $input['access_toll_tags_needed'] = 'yes';
            } else {
                $input['access_toll_tags_needed'] = 'no';
            }
            // Need Stickers
            if ($input['stickers_needed'] == 1) {
                $input['stickers_needed'] = 'yes';
            } else {
                $input['stickers_needed'] = 'no';
            }
            $vehicle = Auth::guard('api')->user()->vehicles->find($id);
            if ($vehicle) {
                $update = $vehicle->fill($input)->save();
                if($update) {
                    if ($request->hasFile('vehicle_document')) {
                        if ($vehicle->vehicleDocuments()) {
                            $filePath = $vehicle->vehicleDocuments->pluck('file_path')->first();
                            if (file_exists(storage_path('app/'.$filePath))) { 
                                unlink(storage_path('app/'.$filePath));
                            }
                            $vehicle->vehicleDocuments()->delete();
                        }

                        $file = $request->file('vehicle_document');
                        $name = $file->getClientOriginalName();
                        $filename = $vehicle->id.'-'.$name;
                        $path = $file->storeAs('public/vehicle_documents', $filename);
                        //store image file into directory and db
                        $vehicleDocument = new VehicleDocument();
                        $vehicleDocument->vehicle_id = $vehicle->id;
                        $vehicleDocument->file_type = $input['document_type'];
                        $vehicleDocument->file_path = $path;
                        $vehicleDocument->status = 1;
                        $vehicleDocument->save();
                    }
                    Log::info('Vehicle updated successfully for vehicle id: '.$id);
                    return $this->sendResponse([], 'Vehicle updated successfully.');
                } else {
                    return $this->sendError('Failed to update vehicle.');   
                }
            } else {
                return $this->sendError('Vehicle not found.');  
            }
        } catch (Exception $e) {
            Log::error('Failed to update vehicle due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update vehicle.');
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
            $vehicle = Auth::guard('api')->user()->vehicles->find($id);
            if ($vehicle) {
                if ($vehicle->vehicleDocuments()) {
                    $filePath = $vehicle->vehicleDocuments->pluck('file_path')->first();
                    if (file_exists(storage_path('app/'.$filePath))) { 
                        unlink(storage_path('app/'.$filePath));
                    }
                    $vehicle->vehicleDocuments()->delete();
                }
                $vehicle->delete();
                Log::info('Vehicle deleted successfully for vehicle id: '.$id);
                return $this->sendResponse([], 'Vehicle deleted successfully.');
            } else {
                return $this->sendError('Vehicle not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete vehicle due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete vehicle.');
        }
    }
}
