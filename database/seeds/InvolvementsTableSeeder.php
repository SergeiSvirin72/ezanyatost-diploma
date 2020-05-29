<?php

use Illuminate\Database\Seeder;

class InvolvementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $associations = \App\Association::all();

        \App\Student::all()->each(function ($student) use ($associations) {
            $associations->random(rand(0, 3))->each(function ($association) use ($student) {
                $involvement = \App\Involvement::create([
                    'association_id' => $association->id,
                    'student_id' => $student->id,
                ]);
            });
        });
    }
}
