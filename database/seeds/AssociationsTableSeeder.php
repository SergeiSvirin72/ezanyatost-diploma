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
                'Клуб «Юный правовед»',
                'Мой друг - компьютер',
                'Робототехника',
            ],
            [
                'Пионербол',
                'Воллейбол',
                'Футбол',
                'ОФП',
                'Эстетическая гимнастика',
                'Экологический туризм',
            ],
            [
                'Рукоделие',
                'Изостудия «Радуга»',
                'Кружок по деревообработке',
                'Вокальная студия',
            ],
            [
                'Основы духовно-нравственной культуры народов России',
                'Активисты школьного музея',
            ],
        ];

        \App\Course::all()->each(function ($course) use ($associations) {
            foreach ($associations[($course->id)-1] as $name) {
                $association = \App\Association::create([
                    'name' => $name,
                    'course_id' => $course->id,
                ]);
            };
        });
    }
}
