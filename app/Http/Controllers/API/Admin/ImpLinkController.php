<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ImpLink;
use App\Http\Resources\ImpLink as ImpLinkResource;
use App\Http\Requests\StoreImpLinkRequest;

class ImpLinkController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $impLink = ImpLink::where('description', 'LIKE', '%'.$request->get('description'). '%')
            ->where('url', 'LIKE' , '%'.$request->get('url').'%')
            ->get();

            if (count($impLink)) {
                Log::info('Imp-link data displayed successfully.');
                return $this->sendResponse(ImpLinkResource::collection($impLink), 'Imp-link data retrieved successfully.');
            } else {
                return $this->sendError('No data found for imp-link.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve imp-link data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve imp-link data.');
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
    public function store(StoreImpLinkRequest $request)
    {
        try {
            $input = $request->all();
            $input['added_by'] = Auth::guard('api')->user()->id;
            $impLink = ImpLink::create($input);
            if ($impLink) {
                Log::info('Imp-link added successfully.');
                return $this->sendResponse(new ImpLinkResource($impLink), 'Imp-link added successfully.');
            } else {
                return $this->sendError('Failed to add imp-link.');   
            }
        } catch (Exception $e) {
            Log::error('Failed to add imp-link due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add imp-link.');
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
            $impLink = ImpLink::findOrFail($id);
            Log::info('Showing imp-link data for impLink id: '.$id);
            return $this->sendResponse(new ImpLinkResource($impLink), 'Imp-link retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve imp-link data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve imp-link data, imp-link not found.');
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
            $impLink = ImpLink::findOrFail($id);
            Log::info('Edit imp-link data for impLink id: '.$id);
            return $this->sendResponse(new ImpLinkResource($impLink), 'Imp-link retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit imp-link data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit imp-link data, imp-link not found.');
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
        try {
            $input = $request->except(['_method']);
            $impLink = ImpLink::findOrFail($id);
            if ($impLink) {
                $update = $impLink->fill($input)->save();
                if ($update) {
                    Log::info('Imp-link updated successfully for imp-link id: '.$id);
                    return $this->sendResponse([], 'Imp-link updated successfully.');
                } else {
                    return $this->sendError('Failed to update imp-link.');      
                }
            } else {
                return $this->sendError('Imp-link not found.');   
            }
        } catch (Exception $e) {
            Log::error('Failed to update imp-link due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update imp-link.');
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
            $impLink = ImpLink::findOrFail($id);
            if ($impLink) {
                if ($impLink->delete()){
                    return $this->sendResponse([], 'Imp-link deleted successfully.');
                } else {
                    return $this->sendError('Imp-link can not be deleted.');
                }
            } else {
                return $this->sendError('Imp-link not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete imp-link due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete imp-link.');
        }
    }
}
