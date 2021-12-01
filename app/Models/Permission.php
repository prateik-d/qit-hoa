<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    public $timestamps = true;

    protected $fillable = [
        'type',
        'status',
    ];

    public function insertData($request) {
        if($request->status=='on') {
            $status = 1;
        } else {
            $status = 0;
        }
        return Permission::create([
            'type' => $request->type,
            'status'=>$status
        ]);
    }

    public function updateData($request,$id) {
        if($request->input('status')=='on') {
            $status = 1;
        } else {
            $status = 0;
        }
        $permission = Permission::find($id);
        $permission->type = $request->input('type');
        $permission->status = $status;
        return $permission->update();
    }
}
