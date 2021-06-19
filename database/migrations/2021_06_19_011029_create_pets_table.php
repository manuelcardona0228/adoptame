<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->timestamp('date_of_birth')->nullable();
            $table->string('photo_url', 156)->nullable();

            $table->foreignId('species_id')
                    ->constrained('species')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreignId('breed_id')
                    ->constrained('breeds')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreignId('institution_id')
                    ->constrained('institutions')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

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
        Schema::dropIfExists('pets');
    }
}
