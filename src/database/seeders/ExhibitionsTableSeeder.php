<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExhibitionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {

			if ($i < 5) {
				$profile_id = 1;
			} elseif (5 <= $i && $i < 10) {
				$profile_id = 2;
			}

			$item_id = Item::find($i + 1)->id;
			if ($item_id == 4 || $item_id == 10) {
				$status = 3;
			} elseif ($item_id == 2 || $item_id == 6 || $item_id == 8) {
				$status = 2;
			} else {
				$status = 1;
			}

				DB::table('exhibitions')->insert([
                'profile_id' => $profile_id,
                'item_id'    => $item_id,
				'status'     => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}