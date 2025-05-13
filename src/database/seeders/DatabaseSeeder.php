<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ItemCategoryTableSeeder::class);
        $this->call(LikesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
		$this->call(ExhibitionsTableSeeder::class);
        $this->call(PurchasesTableSeeder::class);
		$this->call(TransactionsTableSeeder::class);
		$this->call(MessagesTableSeeder::class);
		$this->call(ReviewsTableSeeder::class);
    }
}
