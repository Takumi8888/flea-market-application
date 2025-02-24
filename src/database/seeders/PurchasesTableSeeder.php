<?php

namespace Database\Seeders;

use App\Models\Profile\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 4; $i++) {
            $id = Profile::inRandomOrder()->first()->id;
            $profile = Profile::find($id);
            $shipping_address = $profile->postcode . $profile->address . $profile->building;

            DB::table('purchases')->insert([
                'profile_id'       => $id,
                'item_id'          => $i*3,
                'purchase'         => rand ( 1, 2 ),
                'shipping_address' => $shipping_address,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }
}
