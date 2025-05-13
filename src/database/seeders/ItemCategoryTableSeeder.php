<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $i = 0;
        for ($j = 0; $j < 10; $j++) {
            $i++;
            for ($k = 0; $k < 3; $k++) {
                DB::table('item_category')->insert([
                    'item_id'     => $i,
                    'category_id' => Category::inRandomOrder()->first()->id,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
    }
}
