<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\PermissionHeading;

class PermissionsController extends Controller
{
    protected $permissions;
    public function __construct(){
        $this->permissions = new Permission();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        dd($permissions);
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $headings = PermissionHeading::pluck('heading','id');
        return view('permissions.create')->with(compact('headings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->permissions->insertData($request);
            return redirect()->route('permissions')->withSuccess(__('Permission created successfully.'));
        } catch(Exception $e)  {
            return redirect('permission.add')->with('failed',"Operation failed");
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $headings = PermissionHeading::pluck('heading','id');
        $permission = Permission::find($id);
        return view('permissions.edit')->with(compact('permission','headings'));
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
            $save = $this->permissions->updateData($request,$id);
            return redirect()->route('permissions')->withSuccess(__('Permission updated successfully.'));
        }  catch(Exception $e)  {
            return redirect('permission.edit')->with('failed',"Operation failed");
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
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permissions')->with('success', 'Permission has been deleted');
    }
}
