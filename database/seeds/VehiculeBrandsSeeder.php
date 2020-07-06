<?php

use Illuminate\Database\Seeder;
use App\VehiculeBrands;

class VehiculeBrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        VehiculeBrands::create([
          'brand' => 'TOYOTA'
        ]);
        VehiculeBrands::create([
          'brand' => 'NISSAN'
        ]);
        VehiculeBrands::create([
          'brand' => 'CHANGAN'
        ]);
        VehiculeBrands::create([
          'brand' => 'CHERY'
        ]);
        VehiculeBrands::create([
          'brand' => 'FORD'
        ]);
        VehiculeBrands::create([
          'brand' => 'SUBARU'
        ]);
        VehiculeBrands::create([
          'brand' => 'HYUNDAI'
        ]);
        VehiculeBrands::create([
          'brand' => 'KIA'
        ]);
        VehiculeBrands::create([
          'brand' => 'CHEVROLET'
        ]);
        VehiculeBrands::create([
          'brand' => 'SUZUKI'
        ]);
        VehiculeBrands::create([
          'brand' => 'RENAULT'
        ]);
        VehiculeBrands::create([
          'brand' => 'MITSUBISHI'
        ]);
        VehiculeBrands::create([
          'brand' => 'VOLKSWAGEN'
        ]);
    }
}
