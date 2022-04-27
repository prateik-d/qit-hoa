<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Voting;
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
            $votingCategories = VotingCategory::orderBy('title', 'ASC')->get();

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
        try {
            $votingCategories = VotingCategory::orderBy('category', 'ASC')
                                ->get();

            if (count($votingCategories)) {
                Log::info('Voting categories data displayed successfully.');
                return $this->sendResponse($votingCategories, 'Voting categories data retrieved successfully.');
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
            $voting = Voting::create($input);
            $nominees = $input['nominee'];
            if (count($nominees)) {
                $voting->nominees()->attach($nominees);
            }
            if ($voting) {
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
            $voting = Voting::findOrFail($id);
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
        try {
            $voting = Voting::findOrFail($id);
            Log::info('Edit voting data for voting id: '.$id);
            return $this->sendResponse($voting, 'Voting retrieved successfully.');
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
            $voting = Voting::findOrFail($id);
            if ($voting) {
                $update = $voting->fill($input)->save();
                if ($update) {
                    $nominees = $input['nominee'];
                    if (count($nominees)) {
                        $voting->nominees()->sync($nominees);
                    }
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $voting = Voting::findOrFail($id);
            if ($voting) {
                $votingNominee = $voting->nomminees()->detach();
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
}
