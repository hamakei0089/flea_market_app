<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
    DB::table('payment_methods')->insert([
            [
            'name' => 'コンビニ支払い',
            ],

            [
            'name' => 'カード支払い',
            ],
        ]);
    }
}