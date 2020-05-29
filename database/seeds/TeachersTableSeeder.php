<?php

use Illuminate\Database\Seeder;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        \App\User::where('role_id', 3)->get()->each(function ($user) {
//            $organisation = \App\Organisation::all()->random();
//            $teacher = \App\Teacher::create([
//                'user_id' => $user->id,
//                'organisation_id' => $organisation->id,
//            ]);
//        });

        $weights = [1, 1, 1, 2];

        \App\Association::all()->each(function ($association) use ($weights) {
            for ($i = 0; $i < $weights[array_rand($weights)]; $i++) {
                $user = factory(App\User::class)->create(['role_id' => 3]);
                $teacher = \App\Teacher::create([
                    'user_id' => $user->id,
                    'association_id' => $association->id,
                ]);
            }
        });
    }
}
