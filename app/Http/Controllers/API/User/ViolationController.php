<?php

namespace App\Http\Controllers\API\User;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Violation;
use App\Http\Resources\Violation as ViolationResource;
use App\Http\Requests\StoreViolationRequest;

class ViolationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $violations = Violation::with('violationType')
						->where('status', 'open')
                        ->where('violation_type', 'LIKE', '%'.$request->get('type'). '%')
                        ->where('date', 'LIKE', '%'.$request->get('date'). '%')
                        ->where('status', 'LIKE', '%'.$request->get('status'). '%');

            $violations = $violations->whereHas('violationType', function($query) use($request) {
                        $query->where('type', 'LIKE' , '%'.$request->get('title').'%');
                        })->get();
                
            if (count($violations)) {
                Log::info('Violations data displayed successfully.');
                return $this->sendResponse(ViolationResource::collection($violations), 'Violations data retrieved successfully.');
            } else {
                return $this->sendError('No data found for violations');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve violations data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve violations data.');
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
            $violation = Violation::findOrFail($id);
            Log::info('Showing violation data for violation id: '.$id);
            return $this->sendResponse(new ViolationResource($violation), 'Violation retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve violation data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve violation data, violation not found.');
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
            $violation = Violation::findOrFail($id);
            Log::info('Edit violation data for violation id: '.$id);
            return $this->sendResponse(new ViolationResource($violation), 'Violation retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit violation data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit violation data, violation not found.');
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
