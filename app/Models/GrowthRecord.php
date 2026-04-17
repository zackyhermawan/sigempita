<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrowthRecord extends Model
{
    protected $fillable = [
        'child_id',
        'record_date',
        'weight',
        'height',
        'nutritional_status',
        'admin_notes',
        'admin_id',
    ];

    public function child()
    {
        return $this->belongsTo(Children::class);
    }
    
    public function admin()
    {
        // Hubungkan ke model User (sesuaikan jika nama modelnya berbeda)
        return $this->belongsTo(User::class, 'admin_id'); 
    }

    public function monitoring()
    {
        // Parameter kedua adalah foreign key di tabel monitorings
        return $this->hasOne(Monitoring::class, 'growth_record_id');
    }
}