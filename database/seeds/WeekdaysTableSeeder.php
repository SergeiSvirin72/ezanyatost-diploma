<?php

use Illuminate\Database\Seeder;

class WeekdaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $weekdays = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье',];
        $weekdays_short = ['ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ', 'ВС',];
        $weekdays_number = ['1', '2', '3', '4', '5', '6', '0',];

        for ($i = 0; $i < count($weekdays); $i++) {
            \App\Weekday::create([
                'name' => $weekdays[$i],
                'short_name' => $weekdays_short[$i],
                'number' => $weekdays_number[$i],
            ]);
        }
    }
}
