<?php

use Illuminate\Database\Seeder;

class BrakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Brake::class, 100)->create();
    }
}
