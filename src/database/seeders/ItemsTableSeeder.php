<?php

namespace Database\Seeders;

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
            'image'        => 'public/image/item/user1_watch.jpg',
            'condition'    => 1,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => 'HDD',
            'brand'        => 'ブランド名',
            'price'        => 5000,
            'detail'       => '高速で信頼性の高いハードディスク',
            'image'        => 'public/image/item/user1_HDD.jpg',
            'condition'    => 2,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => '玉ねぎ3束',
            'brand'        => 'ブランド名',
            'price'        => 300,
            'detail'       => '新鮮な玉ねぎ3束のセット',
            'image'        => 'public/image/item/user1_onion.jpg',
            'condition'    => 3,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => '革靴',
            'brand'        => 'ブランド名',
            'price'        => 4000,
            'detail'       => 'クラシックなデザインの革靴',
            'image'        => 'public/image/item/user1_LeatherShoes.jpg',
            'condition'    => 4,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => 'ノートPC',
            'brand'        => 'ブランド名',
            'price'        => 45000,
            'detail'       => '高性能なノートパソコン',
            'image'        => 'public/image/item/user1_Laptop.jpg',
            'condition'    => 1,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => 'マイク',
            'brand'        => 'ブランド名',
            'price'        => 8000,
            'detail'       => '高音質のレコーディング用マイク',
            'image'        => 'public/image/item/user2_microphone.jpg',
            'condition'    => 2,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => 'ショルダーバッグ',
            'brand'        => 'ブランド名',
            'price'        => 3500,
            'detail'       => 'おしゃれなショルダーバッグ',
            'image'        => 'public/image/item/user2_LeatherBag.jpg',
            'condition'    => 3,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => 'タンブラー',
            'brand'        => 'ブランド名',
            'price'        => 500,
            'detail'       => '使いやすいタンブラー',
            'image'        => 'public/image/item/user2_Tumbler.jpg',
            'condition'    => 4,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => 'コーヒーミル',
            'brand'        => 'ブランド名',
            'price'        => 4000,
            'detail'       => '手動のコーヒーミル',
            'image'        => 'public/image/item/user2_CoffeeGrinder.jpg',
            'condition'    => 1,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('items')->insert([
            'name'         => 'メイクセット',
            'brand'        => 'ブランド名',
            'price'        => 2500,
            'detail'       => '便利なメイクアップセット',
            'image'        => 'public/image/item/user2_makeupSet.jpg',
            'condition'    => 2,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }
}
