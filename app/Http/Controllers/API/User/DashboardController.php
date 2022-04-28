<?php

namespace App\Http\Controllers\API\User;
   
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\AccRequest;
use App\Models\AccDocument;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketImage;
use App\Models\Event;

class DashboardController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::guard('api')->user();

            $accRequest = AccRequest::whereHas('users', function ($query) use($request, $user) {
                $query->where('user_id', $user->id)->where('title', 'LIKE', '%'.$request->get('title'). '%')
                ->where('acc_requests.created_at', 'LIKE' , '%'.$request->get('date').'%')
                ->where('status', 'LIKE' , '%'.$request->get('status').'%');
            })->count();

            $ticket = Ticket::where('status', 'open')->count();

			$openViolations =  $user->violations->where('status', 'open')->count();
            $myViolations = $user->violations->count();

			$currentDateTime = Carbon::now()->toDateTimeString();
			$upcomingEvents = Event::where('start_datetime', '>', $currentDateTime)->where('status', '!=', 'cancelled')->count();

            Log::info('User dashboard data retrieved successfully.');
            return $this->sendResponse(['accRequest' => $accRequest, 'ticket' => $ticket, 'myViolations' => $myViolations, 'openViolations' => $openViolations, 'upcomingEvents' => $upcomingEvents], 'User dashboard data retrieved successfully.');
        
        } catch (Exception $e) {
            Log::error('Failed to retrieve user dashboard data data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve user dashboard data.');
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
