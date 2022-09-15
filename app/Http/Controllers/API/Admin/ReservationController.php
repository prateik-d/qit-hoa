<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Amenity;
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
            $reservations = Reservation::where('amenity_id', 'LIKE', '%'.$request->get('venue'). '%')
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
            $amenities = Amenity::orderBy('title','asc')->get();

            if (count($amenities)) {
                Log::info('Amenities data displayed successfully.');
                return $this->sendResponse(['amenities' => $amenities], 'Amenities data retrieved successfully.');
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
                $update = $reservation->fill($input)->save();
                if ($update) {
                    Log::info('Reservation updated successfully for reservation id: '.$id);
                    return $this->sendResponse([], 'Reservation updated successfully.');
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
     * get the specified resource notification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function notification() {
        try {
            $notifications = Auth::guard('api')->user()->unreadNotifications;

            if ($notifications) {
                Log::info('Notification received for reservation request.');
                return $this->sendResponse($notifications, 'Notification received for reservation request.');
            } else {
                return $this->sendError('Notifications not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to receive notification for reservation request due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to receive notification for reservation request.');
        }
    }

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

    /**
     * Remove the resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        try {
            $ids = $request->ids;
            $reservations = Reservation::whereIn('id',explode(",",$ids))->delete();
            if ($reservations) {
                Log::info('Selected reservations deleted successfully');
                return $this->sendResponse([], 'Selected reservations deleted successfully.');
            } else {
                return $this->sendError('Reservations not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete reservations due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete reservations.');
        }
    }

}
