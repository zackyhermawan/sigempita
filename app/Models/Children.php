<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'date_of_birth',
        'parent_name',
        'gender'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function growthRecords()
    {
        return $this->hasMany(GrowthRecord::class, 'child_id');
    }

    public function monitorings()
    {
        return $this->hasMany(Monitoring::class, 'child_id');
    }

    public function latestGrowthRecord()
    {
        return $this->hasOne(GrowthRecord::class, 'child_id')->latestOfMany('record_date');
    }

    public function foodRecords()
    {
        return $this->hasMany(FoodRecord::class);
    }

    
}