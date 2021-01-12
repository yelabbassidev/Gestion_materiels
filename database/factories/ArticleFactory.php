<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'designation' => $this->faker->name,
            'code_stihl' => $this->faker->uuid,
            'materiel_adequat' => $this->faker->text('22'),
            'category' => $this->faker->randomElement($array = array ('KUBOTA','STIHL')),
            'quantite_stock' => $this->faker->randomDigit()
        ];
    }
}
