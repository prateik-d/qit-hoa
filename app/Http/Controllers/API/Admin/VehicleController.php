<?php

namespace App\Http\Controllers\API\Admin;
use Illuminate\Support\Facades\Storage;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Notification;
use App\Notifications\NewVehicleNotification;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\DocumentCategory;
use App\Models\Vehicle;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\VehicleColor;
use App\Models\VehicleDocument;
use App\Models\User;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Resources\Vehicle as VehicleResource;

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
            $vehicles = Vehicle::with('user', 'vehicleMake', 'vehicleModel', 'vehicleColor', 'vehicleDocuments')->whereHas('user', function ($query) use($request) {
                $query->where('first_name', 'LIKE', '%'.$request->get('owner'). '%')
                ->orWhere('last_name', 'LIKE', '%'.$request->get('owner'). '%');
            })
            ->whereHas('vehicleMake', function ($query) use ($request) {
                $query->where('make', 'LIKE', '%'.$request->get('make'). '%');
            })
            ->whereHas('vehicleModel', function ($query) use ($request) {
                $query->where('model', 'LIKE', '%'.$request->get('model'). '%');
            })
            ->whereHas('vehicleColor', function ($query) use ($request) {
                $query->where('color', 'LIKE', '%'.$request->get('color'). '%');
            })
            ->when($request->has('status'), function ($query) use ($request) {
                $query->where('status', 'LIKE', '%'.$request->status. '%');
            })
            ->when($request->has('tag_type'), function ($query) use ($request) {
                $query->where('toll_tag_type', 'LIKE', '%'.$request->tag_type. '%');
            })
            ->get();

            if (count($vehicles)) {
                Log::info('Vehicles data displayed successfully.');
                return $this->sendResponse(['vehicles' => $vehicles], 'Vehicles data retrieved successfully.');
            } else {
                return $this->sendError('No data found for vehicles');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve vehicles data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve vehicles data.');
        }
    }
    
    // public function index()
    // {
    //     try {
    //         $notifications = Auth::guard('api')->user()->unreadNotifications;

    //         if ($notifications) {
    //             Log::info('Notification received for new registered vehicle.');
    //             return $this->sendResponse($notifications, 'Notification received for new registered vehicle.');
    //         } else {
    //             return $this->sendError('Notifications not found.');
    //         }
    //     } catch (Exception $e) {
    //         Log::error('Failed to receive notification for new registered vehicle due to occurance of this exception'.'-'. $e->getMessage());
    //         return $this->sendError('Operation failed to receive notification for new registered vehicle.');
    //     }
    // }

    /**
     * Mark notification as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function markNotification(Request $request)
    {
        try {
            Auth::guard('api')->user()
                ->unreadNotifications
                ->when($request->input('id'), function ($query) use ($request) {
                    return $query->where('id', $request->input('id'));
                })
                ->markAsRead();
                Log::info('Notification marked as read.');
                return $this->sendResponse([], 'Notification marked as read.');

        } catch (Exception $e) {
            Log::error('Failed to update notification mark as read due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update notification mark as read.');
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
            $docCategories = DocumentCategory::orderBy('title', 'asc')->get();

            if (count($vehicleMakes) && count($vehicleModels) && count($vehicleColors)) {
                Log::info('Vehicle-makes data, vehicle-models and vehicle-colors data displayed successfully.');
                return $this->sendResponse(['vehicleMakes' => $vehicleMakes, 'vehicleModels' => $vehicleModels, 'vehicleColors' => $vehicleColors, 'docCategories' => $docCategories], 'Vehicle-makes data, vehicle-models and vehicle-colors data displayed successfully.');
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

            if ($input['owner_id'] == Auth::guard('api')->user()->id) {
                $input['owned_by'] = 'self';
            } else {
                $input['owned_by'] = 'user';
            }
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
                return $this->sendResponse(new VehicleResource($vehicle), 'Vehicle added successfully.');
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
            $vehicle = Vehicle::find($id);
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
            $vehicleMakes = VehicleMake::where('status', 1)
                            ->orderBy('make', 'ASC')
                            ->get();
            $vehicleModels = VehicleModel::where('status', 1)
                            ->orderBy('model', 'ASC')
                            ->get();
            $vehicleColors = VehicleColor::where('status', 1)
                            ->orderBy('color', 'ASC')
                            ->get();
            $docCategories = DocumentCategory::orderBy('title', 'asc')->get();
            $vehicle = Vehicle::with('user', 'vehicleMake', 'vehicleModel', 'vehicleColor', 'vehicleDocuments')->find($id);
            Log::info('Edit vehicle data for vehicle id: '.$id);
            return $this->sendResponse(['vehicleMakes' => $vehicleMakes, 'vehicleModels' => $vehicleModels, 'vehicleColors' => $vehicleColors, 'docCategories' => $docCategories, 'vehicle' => $vehicle], 'Vehicle retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit vehicle data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit vehicle data, vehicle not found.');
        }
    }

    /**
     * File upload for violation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileUpload($folder, $fileinput, $input, $files, $vehicle)
    {
        try {
            $allowedfileExtension = ['pdf','jpg','jpeg','png','xlsx','bmp'];
            // foreach ($files as $file) {
            //     $extension = $file->getClientOriginalExtension();
            //     $check = in_array($extension,$allowedfileExtension);
            //     if ($check) {
                $extensions = [];
                    foreach($fileinput as $mediaFiles) {

                        //$name = $mediaFiles->getClientOriginalName();
                        $extensions[$mediaFiles] = pathinfo($mediaFiles, PATHINFO_BASENAME);
                        return $extensions[$mediaFiles];
                        die;
                        $filename = $vehicle->id.'-'.$extensions[$mediaFiles];
                        //$path = $mediaFiles->storeAs('public/'.$folder, $filename);
                        $path = Storage::disk('app')->put('public/'.$folder, $filename);
                        //store document file into directory and db
                        $vehicleDocument = new VehicleDocument();
                        $vehicleDocument->vehicle_id = $vehicle->id;
                        $vehicleDocument->file_type = $input['document_id'];
                        $vehicleDocument->file_path = $path;
                        $vehicleDocument->status = 1;
                        $vehicleDocument->save();
                    }
            //     } else {
            //         return $this->sendError('invalid_file_format'); 
            //     }
            //     Log::info('File uploaded successfully.');
            //     return response()->json(['file uploaded'], 200);
            // }
        } catch (Exception $e) {
            Log::error('Failed to upload event images due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to upload event images.');
        }
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
        //try {
            $input = $request->except(['_method']);
            $input['vehicle_document'] = json_decode($input['vehicle_document'], true);
            return $input;
            die;
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
            $vehicle = Vehicle::find($id);
            if ($vehicle) {
                $update = $vehicle->fill($input)->save();
                if ($update) {
                    if ($request->has('vehicle_document')) {
                        if ($vehicle->vehicleDocuments()) {
                            foreach ($vehicle->vehicleDocuments as $file) {
                                if (file_exists(storage_path('app/'.$file->file_path))) {
                                    unlink(storage_path('app/'.$file->file_path));
                                }
                            }
                            $vehicle->vehicleDocuments()->delete();
                        }
                        $folder = 'vehicle_documents';
                        $fileinput = json_decode($request->vehicle_document, true);
                        $files = json_decode($request->file('vehicle_document'), true);
                        $extensions = [];
                    foreach($files as $mediaFiles) {

                        $name = $mediaFiles->getClientOriginalName();
                        return $name;
                        die;
                        $extensions[$mediaFiles] = pathinfo($mediaFiles);
                        $filename = $vehicle->id.'-'.$extensions[$mediaFiles];
                        $path = $mediaFiles->storeAs('public/'.$folder, $filename);
                        //$path = Storage::disk('app')->put('public/'.$folder, $filename);
                        //store document file into directory and db
                        $vehicleDocument = new VehicleDocument();
                        $vehicleDocument->vehicle_id = $vehicle->id;
                        $vehicleDocument->file_type = $input['document_id'];
                        $vehicleDocument->file_path = $path;
                        $vehicleDocument->status = 1;
                        $vehicleDocument->save();
                    }
                        //$this->fileUpload($folder, $fileinput, $input, $files, $vehicle);
                    }
                    Log::info('Vehicle updated successfully for vehicle id: '.$id);
                    return $this->sendResponse([], 'Vehicle updated successfully.');
                } else {
                    return $this->sendError('Failed to update vehicle.');   
                }
            } else {
                return $this->sendError('Vehicle not found.');  
            }
        // } catch (Exception $e) {
        //     Log::error('Failed to update vehicle due to occurance of this exception'.'-'. $e->getMessage());
        //     return $this->sendError('Operation failed to update vehicle.');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        try {
            $vehicles = Vehicle::with('user', 'vehicleMake', 'vehicleModel', 'vehicleColor', 'vehicleDocuments')->where('status', $request->status)->get();
            Log::info('Showing vehicles for status: '.$request->status);
            return $this->sendResponse(['vehicles' => $vehicles], 'Vehicles retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve vehicles data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve vehicles data, vehicles not found.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function filterByTagType(Request $request)
    {
        try {
            $vehicles = Vehicle::with('user', 'vehicleMake', 'vehicleModel', 'vehicleColor', 'vehicleDocuments')->where('toll_tag_type', $request->tag_type)->get();
            Log::info('Showing vehicles for status: '.$request->tag_type);
            return $this->sendResponse(['vehicles' => $vehicles], 'Vehicles retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve vehicles data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve vehicles data, vehicles not found.');
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
            $vehicle = Vehicle::findOrFail($id);
            if ($vehicle) {
                if ($vehicle->vehicleDocuments()) {
                    foreach ($vehicle->vehicleDocuments as $file) {
                        if (file_exists(storage_path('app/'.$file->file_path))) {
                            unlink(storage_path('app/'.$file->file_path));
                        }
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

    /**
     * Remove the resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        try {
            $ids = $request->id;
            $vehicles = Vehicle::whereIn('id',explode(",",$ids))->get();
            if ($vehicles) {
                foreach ($vehicles as $vehicle) {
                    if ($vehicle->vehicleDocuments()) {
                        foreach ($vehicle->vehicleDocuments as $file) {
                            if (file_exists(storage_path('app/'.$file->file_path))) {
                                unlink(storage_path('app/'.$file->file_path));
                            }
                        }
                        $vehicle->vehicleDocuments()->delete();
                    }
                    $vehicle->delete();
                }
                Log::info('Selected vehicles deleted successfully');
                return $this->sendResponse([], 'Selected vehicles deleted successfully.');
            } else {
                return $this->sendError('Vehicles not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete vehicles due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete vehicles.');
        }
    }
}
