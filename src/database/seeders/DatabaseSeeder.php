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
        $this->call(CategoriesTableSeeder::class);
        $this->call(ConditionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(CategoryItemTableSeeder::class);
    }
}
