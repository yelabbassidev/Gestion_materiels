<?php

namespace Database\Factories;

use App\Models\Gestion_entrees;
use Illuminate\Database\Eloquent\Factories\Factory;

class Gestion_entreesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gestion_entrees::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fournisseur' => $this->faker->name,
            'quantite_entre' => $this->faker->randomDigit(),
            'date_entre' => $this->faker->date(),
            'nbon' => $this->faker->randomDigit(),
            'typebon' => $this->faker->randomElement($array = array ('Fact','BonLivraison')),
            'uploadBon' => $this->faker->imageUrl($width = 640, $height = 480),
        ];
    }
}
