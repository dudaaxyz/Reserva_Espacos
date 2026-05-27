<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    protected $fillable = [
        'name', 'type', 'capacity', 'description', 'is_active'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}