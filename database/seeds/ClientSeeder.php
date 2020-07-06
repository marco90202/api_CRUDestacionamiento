<?php

use Illuminate\Database\Seeder;
use App\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Client::create([
          'firstname' => 'JOSMER',
          'lastname' => 'ZAVALETA GUTIERREZ',
          'email' => 'ezavaleta@parked.com',
          'password' => bcrypt('123456')
        ]);
    }
}
