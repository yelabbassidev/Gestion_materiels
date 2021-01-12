<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Article;
use App\Models\Gestion_entrees;
use App\Models\Gestion_sorties;
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
        $articles = Article::all();
        if($articles->count() ===0){

            $articles = \App\Models\Article::factory(100)->create();
        }


        Gestion_entrees::factory(10)->make()->each(function($gestion_entrees) use ($articles){
            $gestion_entrees->article_id = $articles->random()->id;
            $gestion_entrees->save();
         });
         Gestion_sorties::factory(30)->make()->each(function($gestion_sorties) use ($articles){
            $gestion_sorties->article_id = $articles->random()->id;
            $gestion_sorties->save();
         });
    }
}
