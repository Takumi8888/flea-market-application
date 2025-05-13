<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$name = [
			'西 伶奈',
			'山田 太郎',
			'増田 一世',
		];

		$email = [
			'reina.n@coachtech.com',
			'taro.y@coachtech.com',
			'issei.m@coachtech.com',
		];

		for ($i = 0; $i < 3; $i++) {
			DB::table('users')->insert([
				'name'              => $name[$i],
				'email'             => $email[$i],
				'email_verified_at' => Carbon::now(),
				'password'          => Hash::make('password'),
				'remember_token'    => Str::random(10),
			]);
		}
	}
}
