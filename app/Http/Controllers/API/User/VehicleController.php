<?php

namespace App\Http\Controllers\API\User;
   
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

class VehicleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vehicles = Auth::guard('api')->user()->vehicles;

        if (count($vehicles)) {
            return $this->sendResponse(VehicleResource::collection($vehicles), 'Vehicle retrieved successfully.');
        } else {
            return response()->json(['Result' => 'No Data not found'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicleModels = VehicleModel::where('status', 1)
                        ->orderBy('model', 'ASC')
                        ->get();
        $vehicleMakes = VehicleMake::where('status', 1)
                        ->orderBy('make', 'ASC')
                        ->get();
        $vehicleColors = VehicleColor::where('status', 1)
                        ->orderBy('color', 'ASC')
                        ->get();

        return response()->json(['vehicleMakes'  =>  $vehicleMakes, 'vehicleModels' => $vehicleModels, 'vehicleColors' => $vehicleColors ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicleRequest $request)
    {
        $input = $request->all();
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
            return $this->sendResponse(new VehicleResource($vehicle), 'Vehicle created successfully.');
        } else {
            return $this->sendError('Failed to add vehicle.');   
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
        $vehicle = Auth::guard('api')->user()->vehicles->find($id);
        if ($vehicle) {
            return $this->sendResponse(new VehicleResource($vehicle), 'Vehicle retrieved successfully.');
        } else {
        return $this->sendError('Vehicle not found.');
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
        $vehicle = Auth::guard('api')->user()->vehicles->find($id);
        if ($vehicle) {
            return $this->sendResponse(new VehicleResource($vehicle), 'Vehicle retrieved successfully.');
        } else {
        return $this->sendError('Vehicle not found.');
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
                return $this->sendResponse(new VehicleResource($vehicle), 'Vehicle updated successfully.');
            } else {
                return $this->sendError('Failed to update vehicle.');   
            }
        } else {
            return $this->sendError('Vehicle not found.');  
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
            return $this->sendResponse([], 'Vehicle deleted successfully.');
        } else {
            return $this->sendError('Vehicle not found.');
        }
    }
}
