<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Reservation;
use App\Http\Resources\Reservation as ReservationResource;
use App\Http\Requests\StoreReservationRequest;

class ReservationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $reservations = Reservation::where('ammenity_id', 'LIKE', '%'.$request->get('venue'). '%')
            ->where('booking_date', 'LIKE' , '%'.$request->get('date').'%')
            ->get();

            if (count($reservations)) {
                return $this->sendResponse(ReservationResource::collection($reservations), 'Reservation data retrieved successfully.');
            } else {
                return $this->sendError('No data found for reservation.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve reservation data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve reservation data.');
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
            $ammenities = Ammenity::where('status',1)->orderBy('title','asc')->get();

            if (count($ammenities)) {
                Log::info('Ammenities data displayed successfully.');
                return $this->sendResponse($categories, 'Ammenities data retrieved successfully.');
            } else {
                return $this->sendError('No data found for ammenities.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve ammenities due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve ammenities.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReservationRequest $request)
    {
        try {
            $input = $request->all();
            $input['booked_by'] = Auth::guard('api')->user()->id;
            $reservation = Reservation::create($input);
            if ($reservation) {
                Log::info('Reservation added successfully.');
                return $this->sendResponse(new ReservationResource($reservation), 'Reservation added successfully.');
            } else {
                return $this->sendError('Failed to add reservation.');   
            }
        } catch (Exception $e) {
            Log::error('Failed to add reservation due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add reservation.');
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
            $reservation = Reservation::findOrFail($id);
            Log::info('Showing reservation data for reservation id: '.$id);
            return $this->sendResponse(new ReservationResource($reservation), 'Reservation retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve reservation data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve reservation data, reservation not found.');
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
            $reservation = Reservation::findOrFail($id);
            Log::info('Edit reservation data for reservation id: '.$id);
            return $this->sendResponse(new ReservationResource($reservation), 'Reservation retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit reservation data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit reservation data, reservation not found.');
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
            $reservation = Reservation::findOrFail($id);
            if ($reservation) {
                $updated = $reservation->fill($input)->save();
                if ($updated) {
                    Log::info('Reservation updated successfully for reservation id: '.$id);
                    return $this->sendResponse(new ReservationResource($reservation), 'Reservation updated successfully.');
                } else {
                    return $this->sendError('Failed to update reservation');      
                }
            } else {
                return $this->sendError('Reservation not found.');   
            }
        } catch (Exception $e) {
            Log::error('Failed to update reservation due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update reservation.');
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
            $reservation = Reservation::findOrFail($id);
            if ($reservation) {
                if ($reservation->delete()) {
                    Log::info('Reservation deleted successfully for reservation id: '.$id);
                    return $this->sendResponse([], 'Reservation deleted successfully.');
                } else {
                    return $this->sendError('Reservation can not be deleted.');
                }
            } else {
                return $this->sendError('Reservation not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete reservation due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete reservation.');
        }
    }
}
