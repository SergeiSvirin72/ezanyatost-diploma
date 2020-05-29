<?php

use Illuminate\Database\Seeder;

class AssociationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $associations = [
            [
                'Юный эколог',
                'Проектная деятельность по биологии',
                'Юный правовед',
                'Мой друг - компьютер',
                'Робототехника',
                'Лаборатория интеллекта',
                'Практикум по географии',
                'Математическое моделирование',
                'Компьютерное моделирование',
                'Химический практикум',
            ],
            [
                'Пионербол',
                'Воллейбол',
                'Футбол',
                'ОФП',
                'Экологический туризм',
                'Прикладное плавание',
                'Атлетическая гимнастика',
            ],
            [
                'Рукоделие',
                'Изостудия',
                'Кружок по деревообработке',
                'Вокальная студия',
                'Искусство общения',
                'Творческая лаборатория',
                'Хореографическая студия',
                'Хоровая студия',
            ],
            [
                'Духовная культура России',
                'Активисты школьного музея',
                'Литературный кружок',
                'Исторический клуб',
                'Человек и общество',
                'Мир вокруг нас',
            ],
        ];

//        \App\Course::all()->each(function ($course) use ($associations) {
//            foreach ($associations[($course->id)-1] as $name) {
//                $association = \App\Association::create([
//                    'name' => $name,
//                    'course_id' => $course->id,
//                ]);
//            };
//        });

        $organisations = \App\Organisation::count();
        for($i = 0; $i < count($associations); ++$i) {
            foreach ($associations[$i] as $association) {
                \App\Organisation::all()->random(rand(1, $organisations))
                    ->each(function ($organisation) use ($association, $i) {
                    $assoc = \App\Association::create([
                        'name' => $association,
                        'course_id' => $i + 1,
                        'organisation_id' => $organisation->id,
                    ]);
                });
            }
        }
    }
}
