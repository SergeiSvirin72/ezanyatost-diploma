<?php

use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$organisations = \App\Organisation::where('is_school', 1)->get();
        $letters = ['А', 'Б'];

//        \App\User::where('role_id', 5)->get()->each(function ($user) use ($organisations, $letters) {
//            $organisation = $organisations->random();
//            $student = \App\Student::create([
//                'user_id' => $user->id,
//                'organisation_id' => $organisation->id,
//                'gender_id' => rand(1, 2),
//                'class' => rand(1, 11),
//                'letter' => $letters[array_rand($letters)],
//            ]);
//        });
        for ($i = 1; $i < 6; $i++) {
            $users = factory(App\User::class, 400)->create(['role_id' => 5]);
            foreach ($users as $user) {
                $student = \App\Student::create([
                    'user_id' => $user->id,
                    'organisation_id' => $i,
                    'gender_id' => rand(1, 2),
                    'class' => rand(1, 11),
                    'letter' => $letters[array_rand($letters)],
                ]);
            }
        }

        $users = factory(App\User::class, 100)->create(['role_id' => 5]);
        foreach ($users as $user) {
            $student = \App\Student::create([
                'user_id' => $user->id,
                'organisation_id' => 6,
                'gender_id' => rand(1, 2),
                'class' => rand(1, 4),
                'letter' => $letters[array_rand($letters)],
            ]);
        }

        $users = factory(App\User::class, 200)->create(['role_id' => 5]);
        foreach ($users as $user) {
            $student = \App\Student::create([
                'user_id' => $user->id,
                'organisation_id' => 7,
                'gender_id' => rand(1, 2),
                'class' => rand(5, 11),
                'letter' => $letters[array_rand($letters)],
            ]);
        }

        $users = factory(App\User::class, 100)->create(['role_id' => 5]);
        foreach ($users as $user) {
            $student = \App\Student::create([
                'user_id' => $user->id,
                'organisation_id' => 7,
                'gender_id' => rand(1, 2),
                'class' => rand(1, 4),
                'letter' => $letters[array_rand($letters)],
            ]);
        }
    }
}
