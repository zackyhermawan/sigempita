<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodRecord extends Model
{
    protected $fillable = [
        'child_id',
        'record_date',
        'food_type',
        'feeding_period'
    ];

    public function child()
    {
        return $this->belongsTo(Children::class);
    }
}