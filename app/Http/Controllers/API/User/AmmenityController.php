<?php

namespace App\Http\Controllers\API\User;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Ammenity;
use App\Models\AmmenityDocument;
use App\Http\Requests\StoreAmmenityRequest;
use App\Http\Resources\Ammenity as AmmenityResource;

class AmmenityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $ammenities = Ammenity::with('ammenityDocuments')->where('title', 'LIKE', '%'.$request->get('title'). '%')->get();
            if (count($ammenities)) {
                Log::info('Displayed ammenities data successfully.');
                return $this->sendResponse(new AmmenityResource($ammenities), 'Ammenity retrieved successfully.');
            } else {
                return $this->sendError('No data found for ammenities data.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve ammenities data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve ammenities data.');
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
            $ammenity = Ammenity::with('ammenityDocuments')->findOrFail($id);
            Log::info('Showing ammenity for ammenity id: '.$id);
            return $this->sendResponse(new AmmenityResource($ammenity), 'Ammenity retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve ammenity due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve ammenity, ammenity not found.');
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
