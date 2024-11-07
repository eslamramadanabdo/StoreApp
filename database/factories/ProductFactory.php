<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->productName;
        return [
            'name'             => $name,
            'category_id'      => Category::inRandomOrder()->first()->id,
            'store_id'         => Store::inRandomOrder()->first()->id,
            'slug'             => Str::slug($name),
            'description'      => $this->faker->sentence(15),
            'image'            => $this->faker->imageUrl(600 , 600),
            'price'            => $this->faker->randomFloat(1 , 1 , 499),
            'compare_price'    => $this->faker->randomFloat(1 , 500 , 999),
            'rating'           => $this->faker->randomFloat(1 , 0 , 5),
            'featured'         => $this->faker->randomElement([0, 1]),
            'status'           => $this->faker->randomElement(['active', 'draft' , 'archived'])
        ];
    }
}
