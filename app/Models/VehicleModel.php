<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;

class VehicleModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vehicle_make_id',
        'model',
        'status',
        'created_at',
        'updated_at'
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
