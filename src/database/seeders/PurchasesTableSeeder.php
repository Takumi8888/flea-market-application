<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
			if ($i == 0) {
				$profile_id = 2;
				$status = 1;
			} elseif ($i == 1) {
				$profile_id = 2;
				$status = 2;
			} elseif (2 <= $i && $i < 4) {
				$profile_id = 1;
				$status = 1;
			} elseif ($i == 4) {
				$profile_id = 1;
				$status = 2;
			}

			if ($profile_id == 1) {
				$profile = Profile::find(1);
				$shipping_address = $profile->user_postcode . $profile->user_address . $profile->user_building;
			} elseif ($profile_id == 2) {
				$profile = Profile::find(2);
				$shipping_address = $profile->user_postcode . $profile->user_address . $profile->user_building;
			}

            DB::table('purchases')->insert([
                'profile_id'       => $profile_id,
                'item_id'          => ($i + 1) * 2,
				'status'           => $status,
                'payment_method'   => 'card',
                'shipping_address' => $shipping_address,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }
}