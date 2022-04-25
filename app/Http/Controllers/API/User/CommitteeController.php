<?php

namespace App\Http\Controllers\API\User;
   
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Committee;
use App\Models\CommitteePhoto;
use App\Models\CommitteeMember;
use App\Models\User;
use App\Http\Resources\Committee as CommitteeResource;

class CommitteeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $committee = Committee::with('committeePhotos', 'members')->where('title', 'LIKE', '%'.$request->get('title'). '%')
            ->where('created_at', 'LIKE' , '%'.$request->get('date').'%')
            ->where('status', 'LIKE' , '%'.$request->get('status').'%')->get();

        if (count($committee)) {
            return $this->sendResponse(CommitteeResource::collection($committee), 'Committees retrieved successfully.');
        } else {
            return response()->json(['Result' => 'No Data not found'], 404);
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
        $committee = Committee::find($id);
        if ($committee) {
            return $this->sendResponse(new CommitteeResource($committee), 'Committee retrieved successfully.');
        } else {
            return $this->sendError('Committee not found.');
        }
    }

    public function viewMember($id)
    {
        $user = User::find($id);
        if ($user) {
            return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
        } else {
            return $this->sendError('User not found.');
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
