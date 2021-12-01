<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermissionHeading;

class PermissionHeadingController extends Controller
{
    protected $permission_heading;
    public function __construct(){
        $this->permission_heading = new PermissionHeading();
    }

    public function index()
    {
        $headings = PermissionHeading::all();
        return view('permission_headings.index', compact('headings'));
    }

    
    public function create()
    {
        return view('permission_headings.create');
    }

    public function store(Request $request)
    {
        try {
            $this->permission_heading->insertData($request);
            return redirect()->route('headings')->withSuccess(__('Title added successfully.'));
        } catch(Exception $e)  {
            return redirect('heading.add')->with('failed',"Operation failed");
        }
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $heading = PermissionHeading::find($id);
        return view('permission_headings.edit')->with(compact('heading'));
    }


    public function update(Request $request, $id)
    {
        try {
            $save = $this->permission_heading->updateData($request,$id);
            return redirect()->route('headings')->withSuccess(__('Title updated successfully.'));
        }  catch(Exception $e)  {
            return redirect('heading.edit')->with('failed',"Operation failed");
        }
    }

   
    public function destroy($id)
    {
        $permission_heading = PermissionHeading::findOrFail($id);
        $permission_heading->delete();

        return redirect()->route('headings')->with('success', 'Title has been deleted');
    }
}
