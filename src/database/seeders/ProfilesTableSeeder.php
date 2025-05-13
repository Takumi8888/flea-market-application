<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		$user_name = [
			'reina',
			'taro',
			'issei',
		];

		$user_image = [
			'public/image/profile/Profile1.png',
			'public/image/profile/Profile2.png',
			'public/image/profile/Profile3.png',
		];

		$user_postcode = [
			'101-0031',
			'104-0031',
			'111-0053',
		];

		$user_address = [
			'東京都千代田区東神田1-14-1',
			'東京都中央区京橋3-6-7',
			'東京都台東区浅草橋1-27-9',
		];

		$user_building = [
			'アパホテル No.101',
			'アパホテル No.102',
			'アパホテル No.103',
		];

		for ($i = 0; $i < 3; $i++) {
			DB::table('profiles')->insert([
				'user_id'       => $i + 1,
				'user_name'     => $user_name[$i],
				'user_image'    => $user_image[$i],
				'user_postcode' => $user_postcode[$i],
				'user_address'  => $user_address[$i],
				'user_building' => $user_building[$i],
				'created_at'    => now(),
				'updated_at'    => now(),
			]);
		}
    }
}