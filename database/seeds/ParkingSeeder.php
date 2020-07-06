<?php

use Illuminate\Database\Seeder;
use App\Parking;

class ParkingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Parking::create([
         'place' => 'A101',
         'level' => '1º piso',
         'status' => 'libre',
         'vehicule_id' => 1
       ]);
    }
}
