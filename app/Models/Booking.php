<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'customer_name',
        'customer_contact',
        'customer_email',
        'service_id',
        'booking_date',
        'booking_time',
        'total_price',
        'booking_status',
        'booking_notes',
    ];

    public function salonService()
    {
        return $this->belongsTo(SalonService::class, 'service_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id');
    }
}
