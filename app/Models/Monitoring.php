<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    //
    protected $fillable = [
        'child_id',
        'growth_record_id',
        'admin_id',
        'status',
        'nutritional_status',
        'admin_notes'
    ];

    public function child()
    {
        return $this->belongsTo(Children::class, 'child_id');
    }

    public function growth()
    {
        return $this->belongsTo(GrowthRecord::class, 'growth_record_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
