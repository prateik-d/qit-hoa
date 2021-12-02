<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RolesController extends Controller
{
    protected $role;
    public function __construct(){
        $this->role = new Role();
    }

    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    
    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        try {
            $this->role->insertData($request);
            return redirect()->route('roles')->withSuccess(__('Role added successfully.'));
        } catch(Exception $e)  {
            return redirect('role.add')->with('failed',"Operation failed");
        }
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $role = Role::find($id);
        return view('roles.edit')->with(compact('role'));
    }


    public function update(Request $request, $id)
    {
        try {
            $save = $this->role->updateData($request,$id);
            return redirect()->route('roles')->withSuccess(__('Role updated successfully.'));
        }  catch(Exception $e)  {
            return redirect('role.edit')->with('failed',"Operation failed");
        }
    }

   
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles')->with('success', 'Role has been deleted');
    }
}
