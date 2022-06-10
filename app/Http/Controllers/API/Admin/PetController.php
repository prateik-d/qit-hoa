<?php

namespace App\Http\Controllers\API\Admin;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
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
            $types = PetType::where('status', 1)->orderBy('type','asc')->get();
            $breeds = Breed::where('status', 1)->orderBy('breed','asc')->get();

            $pets = Pet::with('petType', 'breed', 'owner')
            ->where('pet_name', 'LIKE', '%'.$request->get('pet_name'). '%')
            ->whereHas('owner', function ($query) use($request) {
                $query->where(DB::raw('CONCAT(first_name, " ",last_name)'), 'LIKE', '%'.$request->get('owner'). '%')
                ->where('address', 'LIKE', '%'.$request->get('address'). '%');
            })
            ->when($request->has('type'), function ($query) use ($request) {
                $query->where('pet_type_id', 'LIKE', '%'.$request->type. '%');
            })
            ->when($request->has('breed'), function ($query) use ($request) {
                $query->where('breed_id', 'LIKE', '%'.$request->get('breed'). '%');
            })
            ->get();

            if (count($types)) {
                if (count($breeds)) {
                    if (count($pets)) {
                        Log::info('Pet data displayed successfully.');
                        return $this->sendResponse(['types' => $types, 'breeds' => $breeds, 'pets' => $pets], 'Pets data retrieved successfully.');
                    } else {
                        return $this->sendError(['types' => $types, 'breeds' => $breeds], 'No data found for pets');
                    }
                } else {
                    return $this->sendError(['types' => $types], 'No data found for breeds');
                }
            } else {
                return $this->sendError('No data found for pet-types');
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
            $types = PetType::where('status', 1)->orderBy('type','asc')->get();
            $breeds = Breed::where('status', 1)->orderBy('breed','asc')->get();

            if (count($types) && count($breeds)) {
                Log::info('Pet-type data and breed data displayed successfully.');
                return $this->sendResponse(['types' => $types, 'breeds' => $breeds], 'Pet-type data and breed data retrieved successfully.');
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
    public function store(StorePetRequest $request)
    {
        try {
            $input = $request->all();
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
        try {
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
                Log::info('File uploaded successfully.');
                return response()->json(['file uploaded'], 200);
            }
        } catch (Exception $e) {
            Log::error('Failed to upload pet images due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to upload pet images.');
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
            $pet = Pet::with('petType', 'breed', 'owner')->find($id);
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
            $types = PetType::where('status', 1)->orderBy('type','asc')->get();
            $breeds = Breed::where('status', 1)->orderBy('breed','asc')->get();
            $pets = Pet::with('petType', 'breed', 'owner')->find($id);
            Log::info('Edit pet data for pet id: '.$id);
            return $this->sendResponse(['types' => $types, 'breeds' => $breeds, 'pets' => $pets], 'Pet retrieved successfully.');
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
            $pet = Pet::findOrFail($id);
            if ($pet) {
                $update = $pet->fill($input)->save();
                if ($update) {
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
            } else {
                return $this->sendError('Pet not found to update');
            }
        } catch (Exception $e) {
            Log::error('Failed to update pet due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update pet.');
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
            $pets = Pet::with('petType', 'breed', 'owner')->where('pet_type_id', $request->type)->get();
            Log::info('Showing pets for type: '.$request->type);
            return $this->sendResponse(['pets' => $pets], 'Pets retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve pets data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve pets data, pets not found.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function filterByBreed(Request $request)
    {
        try {
            $pets = Pet::with('petType', 'breed', 'owner')->where('breed_id', $request->breed)->get();
            Log::info('Showing pets for breed: '.$request->breed);
            return $this->sendResponse(['pets' => $pets], 'Pets retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve pets data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve pets data, pets not found.');
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
            $pet = Pet::findOrFail($id);
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

    /**
     * Remove the resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        try {
            $ids = $request->id;
            $pets = Pet::whereIn('id',explode(",",$ids))->get();
            if ($pets) {
                foreach ($pets as $pet) {
                    if ($pet->petImages()) {
                        foreach ($pet->petImages as $file) {
                            if (file_exists(storage_path('app/'.$file->img_file_path))) { 
                                unlink(storage_path('app/'.$file->img_file_path));
                            }
                        }
                        $pet->petImages()->delete();
                    }
                    $pet->delete();
                }
                Log::info('Selected pets deleted successfully');
                return $this->sendResponse([], 'Selected pets deleted successfully.');
            } else {
                return $this->sendError('Pets not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete pets due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete pets.');
        }
    }

}
