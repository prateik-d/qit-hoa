<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionHeading extends Model
{
    use HasFactory;

    protected $table = 'permission_headings';

    public $timestamps = true;

    protected $fillable = [
        'heading',
        'status'
    ];

    public function insertData($request) {
        if($request->status=='on') {
            $status = 1;
        } else {
            $status = 0;
        }
        return PermissionHeading::create([
            'heading' => $request->heading,
            'status'=> $status
        ]);
    }

    public function updateData($request,$id) {
        if($request->input('status')=='on') {
            $status = 1;
        } else {
            $status = 0;
        }
        $permission = PermissionHeading::find($id);
        $permission->heading = $request->input('heading');
        $permission->status = $status;
        return $permission->update();
    }
}
