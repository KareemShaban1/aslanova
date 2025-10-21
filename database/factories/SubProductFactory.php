<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubProduct>
 */
class SubProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
	  	'product_id' => Product::inRandomOrder()->first()->id,	
	  	'Width' => $this->faker->numberBetween(100, 1000),
	  	'Height' => $this->faker->numberBetween(100, 1000),
	  	'Thickness' => $this->faker->numberBetween(100, 1000),
	  	'capital' => $this->faker->numberBetween(100, 1000),
	  	'quantity' => $this->faker->numberBetween(100, 1000),
	  	'type' => $this->faker->word(),
	  	'file' => $this->faker->imageUrl(),
	  	'desc' => $this->faker->sentence(),
	  	'price' => $this->faker->numberBetween(100, 1000),
	  	'name' => $this->faker->name(),
	  	'color' => $this->faker->colorName(),
	  	'images' => $this->faker->imageUrl(),
	  	'delivery_price' => $this->faker->numberBetween(100, 1000),
	  	'shipping_price' => $this->faker->numberBetween(100, 1000),
        ];
    }
}