<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

    DB::table('categories')->insert([

            [
            'name' => 'ファッション',
            ],

            [
            'name' => '家電',
            ],

            [
            'name' => 'インテリア',
            ],

            [
            'name' => 'レディース',
            ],

            [
            'name' => 'メンズ',
            ],

            [
            'name' => 'コスメ',
            ],

            [
            'name' => '本',
            ],

            [
            'name' => 'ゲーム',
            ],

            [
            'name' => 'スポーツ',
            ],

            [
            'name' => 'キッチン',
            ],

            [
            'name' => 'ハンドメイド',
            ],

            [
            'name' => 'アクセサリー',
            ],

            [
            'name' => 'おもちゃ',
            ],

            [
            'name' => 'ベビー・キッズ',
            ],

        ]);
    }
}