<?php

use Illuminate\Database\Seeder;

class AssociationOrganisationSeeder extends Seeder
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
            $associations->random(rand(10, 15))->each(function ($association) use ($organisation) {
                $association = \App\AssociationOrganisation::create([
                    'association_id' => $association->id,
                    'organisation_id' => $organisation->id,
                ]);
            });
        });
    }
}
