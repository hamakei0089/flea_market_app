<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

    DB::table('items')->insert([
            [
            'name' => '腕時計',
            'price' => 15000,
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'is_purchased' => false,
            'thumbnail' => 'images/wristwatch.jpg',
            'condition_id' => '1',
            ],

            [
            'name' => 'HDD',
            'price' => 5000,
            'description' => '高速で信頼性の高いハードディスク',
            'is_purchased' => false,
            'thumbnail' => 'images/HDD.jpg',
            'condition_id' => '2',
            ],

            [
            'name' => '玉ねぎ３束',
            'price' => 300,
            'description' => '新鮮な玉ねぎ3束のセット',
            'is_purchased' => false,
            'thumbnail' => 'images/onions.jpg',
            'condition_id' => '3',
            ],

            [
            'name' => '革靴',
            'price' => 4000,
            'description' => 'クラシックなデザインの革靴',
            'is_purchased' => false,
            'thumbnail' => 'images/leather_shoes.jpg',
            'condition_id' => '4',
            ],

            [
            'name' => 'ノートPC',
            'price' => 45000,
            'description' => '高性能なノートパソコン',
            'is_purchased' => false,
            'thumbnail' => 'images/laptop.jpg',
            'condition_id' => '1',
            ],

            [
            'name' => 'マイク',
            'price' => 8000,
            'description' => '高音質のレコーディング用マイク',
            'is_purchased' => false,
            'thumbnail' => 'images/microphone.jpg',
            'condition_id' => '2',
            ],

            [
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'description' => 'おしゃれなショルダーバッグ',
            'is_purchased' => false,
            'thumbnail' => 'images/sholder_bag.jpg',
            'condition_id' => '3',
            ],

            [
            'name' => 'タンブラー',
            'price' => 500,
            'description' => '使いやすいタンブラー',
            'is_purchased' => false,
            'thumbnail' => 'images/tumbler.jpg',
            'condition_id' => '4',
            ],

            [
            'name' => 'コーヒーミル',
            'price' => 4000,
            'description' => '手動のコーヒーミル',
            'is_purchased' => false,
            'thumbnail' => 'images/coffee_grinder.jpg',
            'condition_id' => '1',
            ],

            [
            'name' => 'メイクセット',
            'price' => 2500,
            'description' => '便利なメイクアップセット',
            'is_purchased' => false,
            'thumbnail' => 'images/makeup_tools.jpg',
            'condition_id' => '2',
            ],

        ]);
    }
}
