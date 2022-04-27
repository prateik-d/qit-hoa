<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\TicketCategory;
use App\Http\Requests\StoreTicketCategoryRequest;

class TicketCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $ticketCategories = TicketCategory::where('status', 1)->orderBy('category', 'ASC')->get();
            if (count($ticketCategories)) {
                Log::info('Ticket categories data displayed successfully.');
                return $this->sendResponse($ticketCategories, 'Ticket categories data retrieved successfully.');
            } else {
                return $this->sendError('No data found for ticket categories.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve ticket categories due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Failed to retrieve ticket categories.');
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
    public function store(StoreTicketCategoryRequest $request)
    {
        try {
            $input = $request->all();
            $ticketCategory = TicketCategory::create($input);
            if ($ticketCategory) {
                Log::info('Ticket category added successfully.');
                return $this->sendResponse($ticketCategory, 'Ticket category added successfully.');
            } else {
                return $this->sendError('Failed to add ticket category.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add ticket category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add ticket category');
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
            $ticketCategory = TicketCategory::findOrFail($id);
            Log::info('Showing ticket category for category id: '.$id);
            return $this->sendResponse($ticketCategory, 'Ticket category retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve ticket category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve ticket category data, category not found.');
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
            $ticketCategory = TicketCategory::findOrFail($id);
            Log::info('Edit ticket category for category id: '.$id);
            return $this->sendResponse($ticketCategory, 'Ticket category retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit ticket category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit ticket category data, category not found.');
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
            $ticketCategory = TicketCategory::findOrFail($id);
            if ($ticketCategory) {
                $update = $ticketCategory->fill($input)->save();
                if ($update) {
                    Log::info('Ticket category updated successfully for category id: '.$id);
                    return $this->sendResponse([], 'Ticket category updated successfully.');
                } else {
                    return $this->sendError('Failed to update ticket category.');     
                }
            } else {
                return $this->sendError('Ticket category not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update ticket category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update ticket category.');
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
            $ticketCategory = TicketCategory::findOrFail($id);
            if ($ticketCategory) {
                $ticketCategory->delete();
                Log::info('Ticket category deleted successfully for category id: '.$id);
                return $this->sendResponse([], 'Ticket category deleted successfully.');
            } else {
                return $this->sendError('Ticket category not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete ticket category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete ticket category.');
        }
    }
}
