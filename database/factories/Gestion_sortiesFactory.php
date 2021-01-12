<?php

namespace Database\Factories;

use App\Models\Gestion_sorties;
use Illuminate\Database\Eloquent\Factories\Factory;

class Gestion_sortiesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gestion_sorties::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'designation' => $this->faker->name,
            'quantite_sortie' => $this->faker->randomDigit(),
            'date_sortie' => $this->faker->date(),
            'nbonfact' => $this->faker->randomDigit(),
            'typebon' => $this->faker->randomElement($array = array ('BonSortie')),
            'uploadBon' => $this->faker->imageUrl($width = 640, $height = 480),
        ];
    }
}
