<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
            CustomerSeeder::class,
            SaleSeeder::class,
            SaleDetailSeeder::class,
            WarrantySeeder::class,
            ComplaintSeeder::class,
            HandlingSeeder::class,
            ResolvedComplaintSeeder::class,
        ]);
    }
}
