<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGestionEntreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestion_entrees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained();
            $table->string('fournisseur');
            $table->integer('quantite_entre');
            $table->date('date_entre');
            $table->integer('nbon');
            $table->string('typeBon');
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
        Schema::dropIfExists('gestion_entrees');
    }
}
