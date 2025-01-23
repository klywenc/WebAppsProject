<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word, // Losowa nazwa dania
            'description' => $this->faker->sentence, // Losowy opis
            'price' => $this->faker->randomFloat(2, 5, 20), // Losowa cena w przedziale 5-20
            'category_id' => $this->faker->numberBetween(1, 5), // Losowy ID kategorii (zakładając, że masz co najmniej 5 kategorii)
            'is_available' => $this->faker->boolean, // Losowy stan dostępności (true/false)
        ];
    }
}