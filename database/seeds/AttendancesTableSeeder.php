<?php

use Illuminate\Database\Seeder;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $start    = (new \DateTime())->modify('-7 day');
//        $end      = (new \DateTime())->modify('+7 day');
        $start = new \DateTime('2020-05-01');
        $end = new \DateTime('2020-06-08');

        $weekDays = \DB::table('schedules')
            ->join('teachers', 'schedules.teacher_id', '=', 'teachers.id')
            ->select('teachers.association_id AS association', 'schedules.weekday_id AS weekday')
            ->distinct()
            ->get();

        $values = ['П', 'О', 'У', 'Н',];

        $involvements = \App\Involvement::all()->each(function ($involvement) use ($start, $end, $weekDays, $values) {
            $results = findValue([$involvement->association_id], ['association'], $weekDays);
            $weekDays_prep = [];
            foreach ($results as $result) $weekDays_prep[] = $result->weekday;
            $dates = generateDates($start, $end, $weekDays_prep);

            foreach ($dates as $date) {
                $key = array_rand($values);

                $attendance = \App\Attendance::create([
                    'association_id' => $involvement->association_id,
                    'student_id' => $involvement->student_id,
                    'date' => $date,
                    'value' => $values[$key],
                ]);
            }
        });
    }
}
