<?php

namespace App\Http\Controllers\API\User;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\ImpLink;
use App\Http\Requests\StoreImpLinkRequest;
use App\Http\Resources\ImpLink as ImpLinkResource;

class ImpLinkController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        //
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
