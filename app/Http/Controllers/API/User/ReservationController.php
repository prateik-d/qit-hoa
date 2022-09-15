<?php

namespace App\Http\Controllers\API\User;

use Carbon\Carbon;
use Exception;
use Notification;
use App\Notifications\ReservationRequestNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Amenity;
use App\Models\Reservation;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\Reservation as ReservationResource;

class ReservationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $reservations = Auth::guard('api')->user()->reservations;

            if (count($reservations)) {
                Log::info('Reservation data displayed successfully.');
                return $this->sendResponse(ReservationResource::collection($reservations), 'Reservation data retrieved successfully.');
            } else {
                return $this->sendError('No Data not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve reservations data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve reservations data.');
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
            $amenities = Amenity::orderBy('title','asc')->get();

            if (count($amenities)) {
                Log::info('Amenities data displayed successfully.');
                return $this->sendResponse($amenities, 'Amenities data retrieved successfully.');
            } else {
                return $this->sendError('No data found for amenities.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve amenities due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve amenities.');
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
            $admins = User::whereHas('role', function ($query) {
                $query->where('id', 1);
            })->get();
            $input['booked_by'] = Auth::guard('api')->user()->id;

            $booking_date = $input['booking_date'];
            $start_time = $input['timeslots_start'];
            $end_time = $input['timeslots_end'];
           
           $Availability=  Reservation::where('booking_date', $booking_date)
                    // ->where('payment_status', 'paid')
                    ->where(function ($query) use ($start_time, $end_time) {
                        $query
                           ->whereBetween('timeslots_start', [$start_time, $end_time])
                           ->orWhere(function ($query) use ($start_time, $end_time) {
                                    $query
                                        ->whereBetween('timeslots_end', [$start_time, $end_time]);
                                });
                     })->count();
                     
            $message = 'Selected time-slot is reserved, Please select another available time-slot.';
            if ($Availability == 0) {
                $reservation = Reservation::create($input);
                if ($reservation) {
                    Notification::send($admins, new ReservationRequestNotification($reservation));
                    Log::info('Reservation request sent successfully.');
                    return $this->sendResponse(new reservationResource($reservation), 'Reservation request sent successfully.');
                } else {
                    return $this->sendError('Failed to sent reservation request');     
                }
            }
            return $this->sendError($message);
        } catch (Exception $e) {
            Log::error('Failed to sent reservation request due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to sent reservation request.');
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
