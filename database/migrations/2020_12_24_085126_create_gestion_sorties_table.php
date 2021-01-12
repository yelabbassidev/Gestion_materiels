<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGestionSortiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestion_sorties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained();
            $table->string('designation');
            $table->integer('nbonfact');
            $table->string('typeBon');
            $table->integer('quantite_sortie');
            $table->date('date_sortie');
            $table->string('uploadBon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gestion_sorties');
    }
}
