<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        \App\Models\User::factory(10)->create();
//        \App\Models\Category::factory(10)->create();
//        \App\Models\Listing::factory(10)->create();

        $categories = Category::factory(10)->create();

        User::factory(20)->create()->each(function ($user) use ($categories) {
            Listing::factory(rand(1, 4))->create([
                'user_id' => $user->id,
            ])->each(function ($listing) use ($categories) {
                $listing->category_id = $categories->random(1)[0]->id;
                $listing->save();
            });
        });
    }
}
