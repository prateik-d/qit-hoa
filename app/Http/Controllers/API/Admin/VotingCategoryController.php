<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\VotingCategory;
use App\Http\Requests\StoreVotingCategoryRequest;

class VotingCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $votingCategories = VotingCategory::all();
            if (count($votingCategories)) {
                Log::info('Voting categories data displayed successfully.');
                return $this->sendResponse($votingCategories, 'Voting categories data retrieved successfully.');
            } else {
                return $this->sendError('No data found for voting categories.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve voting categories due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Failed to retrieve voting categories.');
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
    public function store(StoreVotingCategoryRequest $request)
    {
        try {
            $input = $request->all();
            $input['added_by'] = Auth::guard('api')->user()->id;
            $votingCategory = VotingCategory::create($input);
            if ($votingCategory) {
                Log::info('Voting category added successfully.');
                return $this->sendResponse($votingCategory, 'Voting category added successfully.');
            } else {
                return $this->sendError('Failed to add voting category.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add voting category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add voting category');
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
            $votingCategory = VotingCategory::findOrFail($id);
            Log::info('Showing voting category for category id: '.$id);
            return $this->sendResponse($votingCategory, 'Voting category retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve voting category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve voting category data, category not found.');
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
            $votingCategory = VotingCategory::findOrFail($id);
            Log::info('Edit voting category for category id: '.$id);
            return $this->sendResponse($votingCategory, 'Voting category retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit voting category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit voting category data, category not found.');
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
            $votingCategory = VotingCategory::findOrFail($id);
            if ($votingCategory) {
                $update = $votingCategory->fill($input)->save();
                if ($update) {
                    Log::info('Voting category updated successfully for category id: '.$id);
                    return $this->sendResponse([], 'Voting category updated successfully.');
                } else {
                    return $this->sendError('Failed to update voting category.');     
                }
            } else {
                return $this->sendError('Voting category not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update voting category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update voting category.');
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
            $votingCategory = VotingCategory::findOrFail($id);
            if ($votingCategory) {
                $votingCategory->delete();
                Log::info('Voting category deleted successfully for category id: '.$id);
                return $this->sendResponse([], 'Voting category deleted successfully.');
            } else {
                return $this->sendError('Voting category not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete voting category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete voting category.');
        }
    }
}
