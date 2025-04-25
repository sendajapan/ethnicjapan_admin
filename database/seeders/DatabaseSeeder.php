<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\PartCategory;
use App\Models\Shipment;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            AllSeeder::class
        ]);
    }
}
