<?php

namespace Database\Seeders;

use App\Models\Profile\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExhibitionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 9; $i++) {
            DB::table('exhibitions')->insert([
                'profile_id' => Profile::inRandomOrder()->first()->id,
                'item_id'    => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
