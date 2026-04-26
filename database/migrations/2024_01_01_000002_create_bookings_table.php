<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_contact');
            $table->string('customer_email')->nullable();
            $table->foreignId('service_id')->constrained('salon_services')->onDelete('cascade');
            $table->date('booking_date');
            $table->time('booking_time');
            $table->decimal('total_price', 8, 2);
            $table->string('booking_status')->default('pending');
            $table->text('booking_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
