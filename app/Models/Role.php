<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_type',
        'permission_id',
        'created_at',
        'updated_at'
    ];
    
    public function getRoles() {
        return Role::all();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
