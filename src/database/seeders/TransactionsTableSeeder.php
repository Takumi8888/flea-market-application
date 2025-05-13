<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		for ($i = 0; $i < 15; $i++) {

			if (5 <= $i && $i <12) {
				$profile_id = 2;
			} else {
				$profile_id = 1;
			}

			if ($i == 10) {
				$item_id = 2;
			} elseif ($i == 11) {
				$item_id = 4;
			} elseif ($i == 12) {
				$item_id = 6;
			} elseif ($i == 13) {
				$item_id = 8;
			} elseif ($i == 14) {
				$item_id = 10;
			} else {
				$item_id = $i + 1;
			}

			if ($i < 10) {
				$exhibitor = 1;
				$purchaser = 0;
			} else {
				$exhibitor = 0;
				$purchaser = 1;
			}

			if ($i == 0 || $i == 2 || $i == 4 || $i == 6 || $i == 8) {
				$status = 0;
			} elseif ($i == 3 || $i == 9 || $i == 11 || $i == 14) {
				$status = 2;
			} else {
				$status = 1;
			}

			if ($i == 1) {
				$updated_at  = Carbon::now()->addMinute(1);
			} elseif ($i == 5) {
				$updated_at  = Carbon::now()->addMinute(2);
			} elseif ($i == 7) {
				$updated_at  = Carbon::now()->addMinute(3);
			} else {
				$updated_at  = Carbon::now();
			}

			DB::table('transactions')->insert([
				'profile_id'    => $profile_id,
				'item_id'       => $item_id,
				'exhibitor'		=> $exhibitor,
				'purchaser'		=> $purchaser,
				'status'        => $status,
				'created_at'    => now(),
				'updated_at'    => $updated_at,
			]);
		}
    }
}