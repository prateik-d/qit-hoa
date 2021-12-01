<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [
        'name',
        'content',
        'page_title',
        'page_content',
        'page_logo',
        'page_desc',
        'owner',
        'created_by',
        'deleted',
        'created_at'
    ];
}
