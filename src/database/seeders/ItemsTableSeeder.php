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
    public function run(): void
    {
        DB::table('items')->insert([
            'name'         => '腕時計',
            'brand'        => 'ブランド名',
            'price'        => 15000,
            'detail'       => 'スタイリッシュなデザインのメンズ腕時計',
            'image'        => 'image/item/Armani+Mens+Clock.jpg',
            'condition'    => 1,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => 'HDD',
            'brand'        => 'ブランド名',
            'price'        => 5000,
            'detail'       => '高速で信頼性の高いハードディスク',
            'image'        => 'image/item/HDD+Hard+Disk.jpg',
            'condition'    => 2,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => '玉ねぎ3束',
            'brand'        => 'ブランド名',
            'price'        => 300,
            'detail'       => '新鮮な玉ねぎ3束のセット',
            'image'        => 'image/item/iLoveIMG+d.jpg',
            'condition'    => 3,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => '革靴',
            'brand'        => 'ブランド名',
            'price'        => 4000,
            'detail'       => 'クラシックなデザインの革靴',
            'image'        => 'image/item/Leather+Shoes+Product+Photo.jpg',
            'condition'    => 4,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => 'ノートPC',
            'brand'        => 'ブランド名',
            'price'        => 45000,
            'detail'       => '高性能なノートパソコン',
            'image'        => 'image/item/Living+Room+Laptop.jpg',
            'condition'    => 1,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => 'マイク',
            'brand'        => 'ブランド名',
            'price'        => 8000,
            'detail'       => '高音質のレコーディング用マイク',
            'image'        => 'image/item/Music+Mic+4632231.jpg',
            'condition'    => 2,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => 'ショルダーバッグ',
            'brand'        => 'ブランド名',
            'price'        => 3500,
            'detail'       => 'おしゃれなショルダーバッグ',
            'image'        => 'image/item/Purse+fashion+pocket.jpg',
            'condition'    => 3,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => 'タンブラー',
            'brand'        => 'ブランド名',
            'price'        => 500,
            'detail'       => '使いやすいタンブラー',
            'image'        => 'image/item/Tumbler+souvenir.jpg',
            'condition'    => 4,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => 'コーヒーミル',
            'brand'        => 'ブランド名',
            'price'        => 4000,
            'detail'       => '手動のコーヒーミル',
            'image'        => 'image/item/Waitress+with+Coffee+Grinder.jpg',
            'condition'    => 1,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => 'メイクセット',
            'brand'        => 'ブランド名',
            'price'        => 2500,
            'detail'       => '便利なメイクアップセット',
            'image'        => 'image/item/外出メイクアップセット.jpg',
            'condition'    => 2,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }
}
