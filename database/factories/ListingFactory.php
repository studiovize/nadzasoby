<?php

namespace Database\Factories;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ListingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Listing::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(rand(5, 7));
        $datetime = $this->faker->dateTimeBetween('-1 month', 'now');
        $content = '';

        for ($i = 0; $i < 5; $i++) {
            $content .= '<p>' . $this->faker->sentences(rand(5, 10), true) . '</p>';
        }

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . rand(1111, 9999),
            'location' => $this->faker->streetAddress,
            'price' => rand(100, 9999),
            'images' => json_encode([]),
            'is_highlighted' => rand(1, 9) > 7,
            'is_active' => true,
            'is_removed' => false,
            'content' => $content,
            'views' => 0,
            'type' => 'sell',
            'created_at' => $datetime,
            'updated_at' => $datetime,
        ];
    }
}
