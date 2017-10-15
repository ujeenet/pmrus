<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CheckpointSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(ResourceSeeder::class);
        //$this->call(BrakeSeeder::class);

    }
}
