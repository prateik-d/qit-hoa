<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\VehicleDocument;
use App\Models\VehicleColor;
use App\Models\VehicleMake;
use App\Models\VehicleModel;

class Vehicle extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'owned_by',
        'first_name',
        'last_name',
        'phone',
        'email',
        'relationship',
        'vehicle_make_id',
        'vehicle_model_id',
        'vehicle_color_id',
        'license_plate_no',
        'toll_tag_no',
        'toll_tag_type',
        'application_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'id');
    }

    public function vehicleColor()
    {
        return $this->belongsTo(VehicleColor::class);
    }

    public function vehicleMake()
    {
        return $this->belongsTo(VehicleMake::class);
    }

    public function vehicleModel()
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function vehicleDocuments()
    {
        return $this->hasMany(VehicleDocument::class);
    }
}
