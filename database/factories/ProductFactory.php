<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->realText($maxNbChars = 100, $indexSize = 2),
            'price' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 50000),
            'quantity'=>$this->faker->numberBetween($min = 0, $max = 20),
            'created_at'=>$this->faker->dateTimeBetween('-2 month','now'),
            'updated_at'=>$this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
