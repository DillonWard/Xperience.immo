<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Factory(\App\\Models\Agency::class, 10)->create
        \App\Models\Agency::factory(3)->create();
        \App\Models\Programme::factory(10)->create();
        // factory(\App\Models\Agency::class, 3)->create()->each(function ($agency) {
        //     // Seed the relation with one address
        //     $programme = factory(\App\Models\Programme::class, 3)->make();
        //     $agency->address()->save($programme);
        // });

        // $this->call([
        //     AgencySeeder::class,
        //     ProgrammeSeeder::class,
        // ]);
    

    }
}
