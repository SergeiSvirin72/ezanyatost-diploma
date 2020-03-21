<?php

use Illuminate\Database\Seeder;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $associations = \App\Association::all();

        \App\Organisation::all()->each(function ($organisation) use ($associations) {
            $associations->random(rand(3, 5))->each(function ($association) use ($organisation) {
                $association = \App\Activity::create([
                    'association_id' => $association->id,
                    'organisation_id' => $organisation->id,
                ]);
            });
        });
    }
}
