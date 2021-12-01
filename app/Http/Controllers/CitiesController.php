<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;

class CitiesController extends Controller
{
    protected $city;
    public function __construct(){
        $this->city = new City();
    }

    public function index()
    {
        $cities = City::all();
        return view('cities.index', compact('cities'));
    }

    
    public function create()
    {
        $states = State::pluck('state','id');
        return view('cities.create')->with(compact('states'));
    }

    public function store(Request $request)
    {
        try {
            $this->city->insertData($request);
            return redirect()->route('cities')->withSuccess(__('City added successfully.'));
        } catch(Exception $e)  {
            return redirect('city.add')->with('failed',"Operation failed");
        }
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $states = State::pluck('state','id');
        $city = City::find($id);
        return view('cities.edit')->with(compact('city','states'));
    }


    public function update(Request $request, $id)
    {
        try {
            $save = $this->city->updateData($request,$id);
            return redirect()->route('cities')->withSuccess(__('City updated successfully.'));
        }  catch(Exception $e)  {
            return redirect('city.edit')->with('failed',"Operation failed");
        }
    }

   
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return redirect()->route('cities')->with('success', 'City has been deleted');
    }
}
