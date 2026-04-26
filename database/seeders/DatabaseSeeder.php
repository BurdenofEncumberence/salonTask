<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SalonService;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@naillux.com'],
            [
                'name' => 'Salon Admin',
                'password' => Hash::make('password123'),
            ]
        );

        $sampleServices = [
            [
                'service_name' => 'Classic Manicure',
                'service_price' => 250.00,
                'service_duration' => '30 mins',
                'service_description' => 'Basic nail cleaning, shaping, and polish.',
            ],
            [
                'service_name' => 'Classic Pedicure',
                'service_price' => 350.00,
                'service_duration' => '45 mins',
                'service_description' => 'Foot soak, nail trimming, cuticle care, and polish.',
            ],
            [
                'service_name' => 'Gel Polish Manicure',
                'service_price' => 450.00,
                'service_duration' => '1 hour',
                'service_description' => 'Long-lasting gel nail polish with UV cure.',
            ],
            [
                'service_name' => 'Nail Extension (Full Set)',
                'service_price' => 800.00,
                'service_duration' => '2 hours',
                'service_description' => 'Acrylic or gel nail extensions for a full set.',
            ],
            [
                'service_name' => 'Nail Art Design',
                'service_price' => 200.00,
                'service_duration' => '30 mins',
                'service_description' => 'Custom nail art designs per nail or full set.',
            ],
        ];

        foreach ($sampleServices as $serviceData) {
            SalonService::firstOrCreate(
                ['service_name' => $serviceData['service_name']],
                $serviceData
            );
        }
    }
}
