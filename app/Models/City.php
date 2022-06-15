<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\State;
use App\Models\City;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city',
        'state_id'
    ];

    public function state() {
        return $this->belongsTo(State::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function insertData($request) {
        return City::create([
            'state_id'=>$request->state_id,
            'city' => $request->city,
        ]);
    }

    public function updateData($request,$id) {
        $City = City::find($id);
        $City->state_id = $request->input('state_id');
        $City->city = $request->input('city');
        return $City->update();
    }
}
