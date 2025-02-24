<?php

namespace Database\Seeders;

use App\Models\Item\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $i = 0;
        for ($j = 0; $j < 8; $j++) {
            $i++;
            DB::table('likes')->insert([
                'profile_id'  => $i,
                'item_id'     => Item::inRandomOrder()->first()->id,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
