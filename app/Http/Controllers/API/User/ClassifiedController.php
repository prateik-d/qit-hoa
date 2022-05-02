<?php

namespace App\Http\Controllers\API\User;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Classified;
use App\Models\ClassifiedImage;
use App\Http\Requests\StoreClassifiedRequest;

class ClassifiedController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $categories = ClassifiedCategory::where('status', 1)->orderBy('category','asc')->get();

            $classified = Classified::where('title', 'LIKE', '%'.$request->get('item'). '%')
                ->where('classified_category_id', 'LIKE' , '%'.$request->get('category').'%')
                ->where('posted_by', 'LIKE' , '%'.$request->get('posted_by').'%')
                ->where('status', 'LIKE' , '%'.$request->get('status').'%')->get();

            if (count($classified)) {
                Log::info('Classified item displayed successfully.');
                return $this->sendResponse([$categories, $classified], 'Classified item retrieved successfully.');
            } else {
                return $this->sendError('No data found for classified item.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve classified item due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve classified item.');
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
