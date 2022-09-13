<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\Category as CategoryResource;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Category::all();
            if (count($categories)) {
                Log::info('Categories data displayed successfully.');
                return $this->sendResponse(CategoryResource::collection($categories), 'Categories data retrieved successfully.');
            } else {
                return $this->sendError('No data found for categories.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve categories due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Failed to retrieve categories.');
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
    public function store(StoreCategoryRequest $request)
    {
        try {
            $input = $request->all();
            $category = Category::create($input);
            if ($category) {
                Log::info('Category added successfully.');
                return $this->sendResponse(new CategoryResource($category), 'Category added successfully.');
            } else {
                return $this->sendError('Failed to add category.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add category');
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
            $category = Category::findOrFail($id);
            Log::info('Showing category for category id: '.$id);
            return $this->sendResponse(new CategoryResource($category), 'Category retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve category data, category not found.');
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
            $category = Category::findOrFail($id);
            Log::info('Showing category for category id: '.$id);
            return $this->sendResponse(new CategoryResource($category), 'Category retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit category data, category not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $category = Category::findOrFail($id);
            if ($category) {
                $update = $category->fill($input)->save();
                if ($update) {
                    Log::info('Category updated successfully for category id: '.$id);
                    return $this->sendResponse(new CategoryResource($category), 'Category updated successfully.');
                } else {
                    return $this->sendError('Failed to update category.');     
                }
            } else {
                return $this->sendError('Category not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update category due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update category.');
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
            $message = 'Category does not found! Please try again.'; 
            $category = Category::findOrFail($id);
            if ($category) {
                $message = 'Cannot delete category, category is assigned to the lost-found-items!';
                if (!$category->lostFoundItems()->count()) {
                    $category->delete();
                    Log::info('Category deleted successfully for category id: '.$id);
                    return $this->sendResponse([], 'Category deleted successfully.');
				}
                return $this->sendError($message);
            }
        } catch (Exception $e) {
            Log::error($message.'-'. $e->getMessage());
            return $this->sendError($message);
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
            $ids = $request->id;
            $categories = Category::whereIn('id',explode(",",$ids))->delete();
            if ($categories) {
                Log::info('Selected categories deleted successfully');
                return $this->sendResponse([], 'Selected categories deleted successfully.');
            } else {
                return $this->sendError('Categories not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete categories due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete categories.');
        }
    }
}
