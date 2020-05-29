<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Organisation::all()->each(function ($organisation) {
            $events = factory(App\Event::class, rand(30, 40))->create(['organisation_id' => $organisation->id]);
        });


    }
}
