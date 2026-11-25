<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bike;

class BikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bike::query()->delete();

        $bikes = [
            [
                'serial_number' => 'BR-ORBEA-OIZ-H30-001',
                'brand' => 'Orbea',
                'model' => 'Orbea Oiz H30',
                'price_per_hour' => 12.00,
                'status' => 'available',
                'stock' => 2,
                'colour' => 'black',
                'size' => 51,
            ],
            [
                'serial_number' => 'BR-ORBEA-ALMA-H30-002',
                'brand' => 'Orbea',
                'model' => 'Orbea Alma H30',
                'price_per_hour' => 9.00,
                'status' => 'available',
                'stock' => 3,
                'colour' => 'blue',
                'size' => 49,
            ],
            [
                'serial_number' => 'BR-ORBEA-OCCAM-H30-003',
                'brand' => 'Orbea',
                'model' => 'Orbea Occam H30',
                'price_per_hour' => 14.00,
                'status' => 'available',
                'stock' => 2,
                'colour' => 'green',
                'size' => 55,
            ],
            [
                'serial_number' => 'BR-TREK-MARLIN-7-004',
                'brand' => 'Trek',
                'model' => 'Trek Marlin 7',
                'price_per_hour' => 8.00,
                'status' => 'available',
                'stock' => 3,
                'colour' => 'red',
                'size' => 47,
            ],
            [
                'serial_number' => 'BR-TREK-FUEL-EX-5-005',
                'brand' => 'Trek',
                'model' => 'Trek Fuel EX 5',
                'price_per_hour' => 14.00,
                'status' => 'available',
                'stock' => 2,
                'colour' => 'blue',
                'size' => 55,
            ],
            [
                'serial_number' => 'BR-TREK-DOMANE-AL-2-006',
                'brand' => 'Trek',
                'model' => 'Trek Domane AL 2',
                'price_per_hour' => 10.00,
                'status' => 'available',
                'stock' => 2,
                'colour' => 'black',
                'size' => 57,
            ],
            [
                'serial_number' => 'BR-SPECIALIZED-ROCKHOPPER-007',
                'brand' => 'Specialized',
                'model' => 'Specialized Rockhopper Comp 29',
                'price_per_hour' => 8.00,
                'status' => 'available',
                'stock' => 3,
                'colour' => 'orange',
                'size' => 49,
            ],
            [
                'serial_number' => 'BR-SPECIALIZED-CHISEL-COMP-008',
                'brand' => 'Specialized',
                'model' => 'Specialized Chisel Comp',
                'price_per_hour' => 11.00,
                'status' => 'available',
                'stock' => 2,
                'colour' => 'white',
                'size' => 51,
            ],
            [
                'serial_number' => 'BR-GIANT-TALON-1-009',
                'brand' => 'Giant',
                'model' => 'Giant Talon 1',
                'price_per_hour' => 8.00,
                'status' => 'available',
                'stock' => 3,
                'colour' => 'black',
                'size' => 47,
            ],
            [
                'serial_number' => 'BR-CANYON-GRAND-CANYON-7-010',
                'brand' => 'Canyon',
                'model' => 'Canyon Grand Canyon 7',
                'price_per_hour' => 10.00,
                'status' => 'available',
                'stock' => 2,
                'colour' => 'grey',
                'size' => 53,
            ],
        ];

        foreach ($bikes as $bike) {
            Bike::create($bike);
        }
    }
}
