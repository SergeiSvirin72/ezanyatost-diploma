<?php

use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employments = \App\Employment::all();

        $employments->each(function($employment) {
            $schedule = factory(\App\Schedule::class, rand(1, 3))->create([
                'employment_id' => $employment->id,
            ]);
        });
    }
}
