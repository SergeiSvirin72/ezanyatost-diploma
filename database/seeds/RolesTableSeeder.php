<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Администратор',
            'Директор',
            'Преподаватель',
            'Родитель',
            'Обучающийся',
        ];

        foreach ($roles as $role) {
            \App\Role::create([
                'name' => $role,
            ]);
        }
    }
}
