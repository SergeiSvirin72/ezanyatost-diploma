<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'Инвалид' => 1,
            'ОВЗ' => 1,
            'Дети КМНС' => 1,
            'Учёт в КДНиЗП' => 1,
            'Учёт в ОДН' => 1,
            'Опекаемый' => 1,
            'Сирота' => 1,
            'Малообеспеченная' => 2,
            'Неблагополучная' => 2,
            'Многодетная' => 2,
            'Неполная' => 2,
        ];

        foreach ($statuses as $name => $type) {
            \App\Status::create([
                'name' => $name,
                'type' => $type,
            ]);
        }
    }
}
