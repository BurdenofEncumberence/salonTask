<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalonService extends Model
{
    use HasFactory;

    protected $table = 'salon_services';

    protected $fillable = [
        'service_name',
        'service_price',
        'service_duration',
        'service_description',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'service_id');
    }
}
