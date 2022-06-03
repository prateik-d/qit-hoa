<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Voting;
use App\Models\VotingCategory;
use App\Models\VotingOption;
use App\Http\Requests\StoreVotingRequest;
use App\Http\Resources\Voting as VotingResource;

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
            $votings = Voting::with('votingCategory', 'nominees')
            ->whereHas('nominees', function ($query) use($request) {
                $query->where('users.first_name', 'LIKE', '%'.$request->get('name'). '%')
                ->orWhere('users.last_name', 'LIKE', '%'.$request->get('name'). '%');
            })
            ->whereHas('votingCategory', function ($query) use($request) {
                $query->where('voting_categories.title', 'LIKE', '%'.$request->get('title'). '%');
            })
            ->when($request->has('status'), function ($query) use ($request) {
                $query->where('status', 'LIKE', '%'.$request->get('status'). '%');
            })
            ->when($request->has('year'), function ($query) use ($request) {
                $query->where('year', 'LIKE', '%'.$request->get('year'). '%');
            })
            ->get();

            if (count($votings)) {
                Log::info('Voting data displayed successfully.');
                return $this->sendResponse(['votings' => $votings], 'Voting data retrieved successfully.');
            } else {
                return $this->sendError('No data found for voting');
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
        try {
            $votingCategories = VotingCategory::orderBy('title', 'ASC')->get();

            if (count($votingCategories)) {
                Log::info('Voting categories data displayed successfully.');
                return $this->sendResponse(['votingCategories' => $votingCategories], 'Voting categories data retrieved successfully.');
            } else {
                return $this->sendError('No data found for voting categories.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve voting categories due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve voting categories.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVotingRequest $request)
    {
        try {
            $input = $request->all();
            $input['added_by'] = Auth::guard('api')->user()->id;
            if ($request->has('title')) {
                $votingCategory = [
                    'title' => $input['title'],
                    'added_by' => $input['added_by'] 
                ];
                $votingCategory = VotingCategory::firstOrCreate($votingCategory);
                $input['voting_category_id'] = $votingCategory->id;
            }
            $voting = Voting::create($input);
            if ($voting) {
                if (count($input['nominee'])) {
                    $voting->nominees()->attach($input['nominee']);
                }
                // store voting option
                foreach ($input['option'] as $option) {
                    $votingOption = [
                        'voting_id' => $voting->id,
                        'option' => $option
                    ];
                    $saveVotingOption = VotingOption::create($votingOption);
                }
                Log::info('Voting created successfully.');
                return $this->sendResponse($voting, 'Voting created successfully.');
            } else {
                return $this->sendError('Failed to create voting.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to create voting due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to create voting.');
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
            $voting = Voting::find($id);
            if ($voting) {
                Log::info('Showing voting data for voting id: '.$id);
                return $this->sendResponse($voting, 'Voting retrieved successfully.');
            } else {
                return $this->sendError('Voting data not found.');     
            }
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
        try {
            $voting = Voting::where('status', 'open')->find($id);
            if ($voting) {
                Log::info('Edit voting data for voting id: '.$id);
                return $this->sendResponse($voting, 'Voting retrieved successfully.');
            } else {
                return $this->sendError('Voting data not found.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to edit voting data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit voting data, voting not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreVotingRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $voting = Voting::where('status', 'open')->find($id);
            if ($voting) {
                $update = $voting->fill($input)->save();
                if ($update) {
                    $nominees = $input['nominee'];
                    if (count($nominees)) {
                        $voting->nominees()->sync($nominees);
                    }
                    $VotingOption = VotingOption::where('voting_id', $id)->first();
                    $saveVotingOption = $VotingOption->update(['option' => $input['option']]);
                    Log::info('Voting updated successfully.');
                    return $this->sendResponse($voting, 'Voting updated successfully.');
                } else {
                    return $this->sendError('Failed to update voting.');     
                }
            } else {
                return $this->sendError('Voting data not found.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to update voting due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update voting.');
        }
    }

    /**
     * Show archived votings.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archivedVotings($id)
    {
        try {
            $currentDateTime = Carbon::now()->toDateTimeString();
			$votings = voting::where('end_date', '<', $currentDateTime)->where('status', 'closed')->find($id);
            if ($votings) {
                $archivedVotings = $votings->update(['status'=>'archived']);
                Log::info('votings status updated successfully.');
                return $this->sendResponse(new VotingResource($votings), 'votings status updated successfully.');
            } else {
                return $this->sendError('Voting data not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update voting status due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update voting status, votings not found.');
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        try {
            $voting = Voting::where('status', $request->get('status'))->get();
            if (count($voting)) {
                Log::info('Showing votings for status: '.$request->get('status'));
                return $this->sendResponse($voting, 'Votings retrieved successfully.');
            } else {
                return $this->sendError('Voting data not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve voting data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve voting data, voting not found.');
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
            $voting = Voting::where('status', 'open')->find($id);
            if ($voting) {
                if ($voting->nominees) {
                    $voting->nominees()->detach();
                }
                if ($voting->votingOption) {
                    $voting->votingOption->delete();
                }
                if ($voting->votes) {
                    $voting->votes->each->delete();
                }
                $voting->delete();
                Log::info('Voting deleted successfully for voting id: '.$id);
                return $this->sendResponse([], 'Voting deleted successfully.');
            } else {
                return $this->sendError('Voting not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete voting due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete voting.');
        }
    }

    /**
     * Remove the resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        //try {
            $ids = $request->ids;
            $voting = Voting::whereIn('id',explode(",",$ids))->get();
            if ($voting) {
                foreach ($voting as $selectedvotings) {
                    if ($selectedvotings->nominees) {
                        $selectedvotings->nominees()->detach();
                    }
                    if ($selectedvotings->votingOption) {
                        $selectedvotings->votingOption->delete();
                    }
                    if ($selectedvotings->votes) {
                        $selectedvotings->votes->each->delete();
                    }
                    $selectedvotings->delete();
                }
                Log::info('Selected votings deleted successfully');
                return $this->sendResponse([], 'Selected votings deleted successfully.');
            } else {
                return $this->sendError('Votings not found.');
            }
        // } catch (Exception $e) {
        //     Log::error('Failed to delete votings due to occurance of this exception'.'-'. $e->getMessage());
        //     return $this->sendError('Operation failed to delete votings.');
        // }
    }

}
