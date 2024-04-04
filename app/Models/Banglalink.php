<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banglalink extends Model
{
    use HasFactory;
    protected $fillable = [
        'packName',
        'title',
        'price',
        'validity',
        'offerEndsIn'
    ];
}
