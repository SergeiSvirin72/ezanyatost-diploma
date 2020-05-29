<?php

use Illuminate\Database\Seeder;

class StatusStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = \App\Status::all();

        \App\Student::all()->each(function ($student) use ($statuses) {
            $statuses->random(rand(0, 2))->each(function ($status) use ($student) {
                $status_student = \App\StatusStudent::create([
                    'student_id' => $student->id,
                    'status_id' => $status->id,
                ]);
            });
        });
    }
}
