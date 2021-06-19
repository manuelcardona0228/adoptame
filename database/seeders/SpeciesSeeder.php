<?php

namespace Database\Seeders;

use App\Models\Species;
use Illuminate\Database\Seeder;

class SpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $species = new Species();
        $species->name = 'Gato';
        $species->save();

        $species = new Species();
        $species->name = 'Perro';
        $species->save();
    }
}
