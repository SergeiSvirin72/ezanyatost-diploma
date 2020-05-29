<?php

use Illuminate\Database\Seeder;

class GendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genders = [
            'Мужской',
            'Женский',
        ];

        foreach ($genders as $gender) {
            \App\Gender::create([
                'name' => $gender,
            ]);
        }
    }
}
