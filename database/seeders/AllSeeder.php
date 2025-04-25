<?php
// All Seeder
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('providers')->insert([
            [
                'provider_name' => 'FLO TRADING',
                'provider_description' => '',
                'provider_address' => '',
            ],
            [
                'provider_name' => 'NATURAL FOOD IMPORTERS',
                'provider_description' => 'Test',
                'provider_address' => 'test',
            ],
        ]);

        DB::table('customers')->insert([
            [
                'customer_name' => 'Nouman',
                'customer_description' => 'New Customer',
                'customer_address' => 'Tokyo, Japan',
            ],
            [
                'customer_name' => 'Umar',
                'customer_description' => 'Inquiry',
                'customer_address' => '',
            ],
        ]);


        DB::table('categories')->insert([
            [
                'category_name' => 'GRAINS',
                'category_description' => '1',
            ],
            [
                'category_name' => 'BEANS',
                'category_description' => '2',
            ],
            [
                'category_name' => 'FRESH FOOD',
                'category_description' => '3',
            ],
        ]);

        DB::table('users')->insert([
            [
                'name' => 'Boss',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin1234'),
                'role' => 'admin',
                'status' => 'active',
            ],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'mnoman55@gmail.com',
                'password' => bcrypt('123'),
                'role' => 'admin',
                'status' => 'active',
            ]
        ]);


        DB::table('items')->insert([
            [
                'item_name' => 'Cacao grains / VRAEM15 + Cropllo / Grade 1',
                'item_description' => '50kg yute bag',
                'hts_code' => 'HTS 1801.00.00.00'
            ],
            [
                'item_name' => 'White Quinoa Non Pesticides',
                'item_description' => '20kg bag',
                'hts_code' => 'HTS 1008.50.90.00'
            ]
        ]);

    }
}
