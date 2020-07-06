<?php

use Illuminate\Database\Seeder;
use App\Vehicule;

class VehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Vehicule::create([
          'brand' => 'Chery',
          'plate' => 'ACM1PT',
          'client_id' => 1
        ]);
    }
}
