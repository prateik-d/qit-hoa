<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;

class StatesController extends Controller
{
    protected $state;
    public function __construct(){
        $this->state = new State();
    }

    public function index()
    {
        $states = State::all();
        return view('states.index', compact('states'));
    }

    
    public function create()
    {
        return view('states.create');
    }

    public function store(Request $request)
    {
        try {
            $this->state->insertData($request);
            return redirect()->route('states')->withSuccess(__('State added successfully.'));
        } catch(Exception $e)  {
            return redirect('state.add')->with('failed',"Operation failed");
        }
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $state = State::find($id);
        return view('states.edit')->with(compact('state'));
    }


    public function update(Request $request, $id)
    {
        try {
            $save = $this->state->updateData($request,$id);
            return redirect()->route('states')->withSuccess(__('State updated successfully.'));
        }  catch(Exception $e)  {
            return redirect('state.edit')->with('failed',"Operation failed");
        }
    }

   
    public function destroy($id)
    {
        $state = State::findOrFail($id);
        $state->delete();

        return redirect()->route('states')->with('success', 'State has been deleted');
    }
}
