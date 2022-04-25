<?php

namespace App\Http\Controllers\API\User;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Breed;
use App\Models\Pet;
use App\Models\PetType;
use App\Models\PetImage;
use App\Http\Resources\Pet as PetResource;
use App\Http\Requests\StorePetRequest;

class PetController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->all()) {
                $pets = Pet::with('petType', 'breed', 'owner')
                ->where('pet_name', 'LIKE', '%'.$request->get('pet_name'). '%');

                $pets = $pets->whereHas('owner', function($query) use($request) {
                    $query->where('address', 'LIKE' , '%'.$request->get('address').'%')
                    ->where('id', 'LIKE' , '%'.$request->get('owner').'%');
                });

                $pets = $pets->whereHas('breed', function($query) use($request) {
                    $query->where('breed', 'LIKE' , '%'.$request->get('breed').'%');
                });

                $result = $pets->whereHas('petType', function($query) use($request) {
                    $query->where('type', 'LIKE' , '%'.$request->get('type').'%');
                })->get();
            } else {
                $result = Pet::with('petType', 'breed', 'owner')->get();
            }

            $user = Auth::guard('api')->user();
            $myPet = $user->pets()->get();
        
            if (count($result)) {
                Log::info('Pet data displayed successfully.');
                return $this->sendResponse([$result, $myPet], 'Pets data retrieved successfully.');
            } else {
                return $this->sendError('No data found for pets');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve pets data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve pets data.');
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
            $type = PetType::where('status',1)->orderBy('type','asc')->get();
            $breed = Breed::where('status',1)->orderBy('breed','asc')->get();

            if (count($type) && count($breed)) {
                Log::info('Pet-type data and breed data displayed successfully.');
                return $this->sendResponse([$type, $breed], 'Pet-type data and breed data retrieved successfully.');
            } else {
                return $this->sendError('No data found for pet-type and breed.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve pet-type and breed due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve pet-type and breed.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();
            $input['owner_id'] = Auth::guard('api')->user()->id;
            $pet = Pet::create($input);
            if ($pet) {
                if ($request->hasFile('photo')) {
                    $folder = 'pet_photos';
                    $input = $request->photo;
                    $files = $request->file('photo');
                    $this->fileUpload($folder, $input, $files, $pet);
                }
                Log::info('Pet added successfully.');
                return $this->sendResponse(new PetResource($pet), 'Pet added successfully.');
            } else {
                return $this->sendError('Failed to add pet');      
            }
        } catch (Exception $e) {
            Log::error('Failed to add pet due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add pet.');
        }
    }

    /**
     * File upload for Pet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileUpload($folder, $input, $files, $pet)
    {
        $allowedfileExtension = ['pdf','jpg','jpeg','png','xlsx'];
        foreach ($files as $file) {      
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);
            if($check) {
                foreach((array)$input as $mediaFiles) {
                    $name = $mediaFiles->getClientOriginalName();
                    $filename = $pet->id.'-'.$name;
                    $path = $mediaFiles->storeAs('public/'.$folder, $filename);
                    $ext  =  $mediaFiles->getClientOriginalExtension();
                    //store image file into directory and db
                    $petimages = new PetImage();
                    $petimages->pet_id = $pet->id;
                    // $petimages->file_type = $ext;
                    $petimages->img_file_path = $path;
                    $petimages->save();
                }
            } else {
                return $this->sendError('invalid_file_format'); 
            }
            return response()->json(['file_uploaded'], 200);
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
            $pet = Auth::guard('api')->user()->pets()->find($id);
            Log::info('Showing pet data for pet id: '.$id);
            return $this->sendResponse(new PetResource($pet), 'Pet retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve pet data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve pet data, pet not found.');
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
            $pet = Auth::guard('api')->user()->pets()->find($id);
            Log::info('Edit pet data for pet id: '.$id);
            return $this->sendResponse(new PetResource($pet), 'Pet retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit pet data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit pet data, pet not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePetRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $pet = Auth::guard('api')->user()->pets()->find($id);
            if ($pet) {
                $updated = $pet->fill($input)->save();
                if ($updated) {
                    if ($request->hasFile('photo')) {
                        //Delete old images to upload new
                        if ($pet->petImages()) {
                            foreach ($pet->petImages as $file) {
                                if (file_exists(storage_path('app/'.$file->img_file_path))) { 
                                    unlink(storage_path('app/'.$file->img_file_path));
                                }
                            }
                            $pet->petImages()->delete();
                        }
                        //Add new images
                        $folder = 'pet_photos';
                        $input = $request->photo;
                        $files = $request->file('photo');
                        $this->fileUpload($folder, $input, $files, $pet);
                    }
                    Log::info('Pet updated successfully for pet id: '.$id);
                    return $this->sendResponse([], 'Pet updated successfully.');
                } else {
                    return $this->sendError('Failed to update pet');     
                }
            } else{
                return $this->sendError('Cannot update pet, this pet is registered with another owner.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update pet due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update pet.');
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
            $pet = Auth::guard('api')->user()->pets()->find($id);
            if ($pet) {
                if ($pet->petImages()) {
                    foreach ($pet->petImages as $file) {
                        if (file_exists(storage_path('app/'.$file->img_file_path))) { 
                            unlink(storage_path('app/'.$file->img_file_path));
                        }
                    }
                    $pet->petImages()->delete();
                }
                $pet->delete();
                Log::info('Pet deleted successfully for pet id: '.$id);
                return $this->sendResponse([], 'Pet deleted successfully.');
            } else {
                return $this->sendError('Pet not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete pet due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete pet.');
        }
    }
}
