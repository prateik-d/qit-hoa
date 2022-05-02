<?php

namespace App\Http\Controllers\API\User;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Voting;
use App\Models\Vote;
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
            ->where('voting_category_id', 'LIKE', '%'.$request->get('title'). '%')
            ->where('year', 'LIKE', '%'.$request->get('year'). '%')
            ->where('status', 'LIKE', '%'.$request->get('status'). '%')->get(); 
    
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
     * Store a newly created resource in storage.
     * add nominaton for voting
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();
            $input['user_id'] = Auth::guard('api')->user()->id;
            $checkExistNominee = VotingNominee::where('voting_id', $input['voting_id'])->where('user_id', $input['user_id']);

            if ($checkExistNominee->count() == 1) {
                return $this->sendError('Cannot add nomination again, you are already added.');     
            } else {
                $addNomination = VotingNominee::create($input);
                Log::info('Your nomination for voting added successfully.');
                return $this->sendResponse($addNomination, 'Your nomination for voting added successfully.');
            }
        } catch (Exception $e) {
            Log::error('Failed to add nomination for voting due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add nomination again, if once added.');
        }
    }

    /**
     * Store a newly created resource in storage.
     * Give vote for nominee
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function voteNominee(Request $request)
    {
        try {
            $input = $request->all();
            $input['voter_id'] = Auth::guard('api')->user()->id;
            $checkExistVote = Vote::where('voting_id', '=', $input['voting_id'])->where('voter_id', '=', $input['voter_id'])->count();
            if ($checkExistVote > 0) {
                return $this->sendError('Cannot vote again, your vote is already completed.');     
            } else {
                $vote = Vote::create($input);
                Log::info('Vote added successfully.');
                return $this->sendResponse($vote, 'Vote added successfully.');
            }
        } catch (Exception $e) {
            Log::error('Failed to add vote due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add vote.');
        }
    }

    /**
     * Display the specified resource.
     * View voting details with nominees to add vote
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $voting = Voting::findOrFail($id);
            // return $voting->nominees->where('deleted_at', '=', 'null');
            // die;
            Log::info('Showing voting data for voting id: '.$id);
            return $this->sendResponse($voting, 'Voting retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve voting data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve voting data, voting not found.');
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
     * Remove nomination from voting
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $voting = Voting::findOrFail($id);
            if ($voting) {
                $votingNominee = Auth::guard('api')->user()->votings->find($id);
                if ($votingNominee) {
                    $votingNominee->pivot->update(['deleted_at' => Carbon::now()]);
                    Log::info('Your nomination has removed successfully for voting id: '.$id);
                    return $this->sendResponse([], 'Your nomination has removed successfully .');
                } else {
                    return $this->sendError('Failed to remove nomination.');
                }
            } else {
                return $this->sendError('Voting not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to remove nomination due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to remove nomination.');
        }
    }
}
