<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            OrganisationsTableSeeder::class,
            CoursesTableSeeder::class,
            AssociationsTableSeeder::class,
            ActivitiesTableSeeder::class,
            EmploymentsTableSeeder::class,
            SchedulesTableSeeder::class,
        ]);
    }
}
