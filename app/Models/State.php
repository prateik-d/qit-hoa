<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table = 'states';

    public $timestamps = true;

    protected $fillable = [
        'state'
    ];

    public function insertData($request) {
        return State::create([
            'state' => $request->state,
        ]);
    }

    public function updateData($request,$id) {
        $State = State::find($id);
        $State->state = $request->input('state');
        return $State->update();
    }
}
