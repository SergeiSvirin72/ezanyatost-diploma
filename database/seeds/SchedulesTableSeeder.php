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
//        $teachers = \App\Teacher::all();
//
//        $teachers->each(function($teacher) {
//            $schedule = factory(\App\Schedule::class, rand(1, 2))->create([
//                'teacher_id' => $teacher->id,
//            ]);
//        });

        $associations = \App\Association::all();
        $weights = [1, 2, 2, 2, 3];

        $associations->each(function($association) use ($weights) {
            $teacher = \App\Teacher::where('association_id', $association->id)->get()->random();
            $schedule = factory(\App\Schedule::class, $weights[array_rand($weights)])->create([
                'teacher_id' => $teacher->id,
            ]);
        });
    }
}
