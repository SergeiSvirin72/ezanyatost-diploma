<?php

use Illuminate\Database\Seeder;

class EmploymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::where('role_id', 3)->get();

        \App\Activity::all()->each(function ($activity) use ($users) {
            $users->random(rand(1, 2))->each(function ($user) use ($activity) {
                $employment = \App\Employment::create([
                    'activity_id' => $activity->id,
                    'user_id' => $user->id,
                ]);
            });
        });
    }
}
