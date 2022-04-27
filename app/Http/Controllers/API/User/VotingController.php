<?php

namespace App\Http\Controllers\API\User;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Voting;
use App\Models\VotingCategory;
use App\Models\VotingNominee;
use App\Http\Requests\StoreVotingRequest;

class VotingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $votingCategories = VotingCategory::orderBy('title', 'ASC')
                                ->get();

            $voting = Voting::with('votingCategory')
            ->where('year', 'LIKE', '%'.$request->get('year'). '%')
            ->where('status', 'LIKE', '%'.$request->get('status'). '%');
    
            $voting = $voting->whereHas('votingCategory', function($query) use($request) {
                $query->where('title', 'LIKE', '%'.$request->get('title'). '%');
            })->get();

            if (count($votingCategories)) {
                if (count($voting)) {
                    Log::info('Voting data displayed successfully.');
                    return $this->sendResponse([$votingCategories, $voting], 'Voting data retrieved successfully.');
                } else {
                    return $this->sendError('No data found for voting');
                }
            } else {
                return $this->sendError('No data found for categories');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve voting data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve voting data.');
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
