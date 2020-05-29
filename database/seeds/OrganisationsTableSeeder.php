<?php

use Illuminate\Database\Seeder;

class OrganisationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        \App\User::where('role_id', 2)->get()->each(function ($user) {
//            $organisation = factory(\App\Organisation::class)->create([
//                'director_id' => $user->id,
//            ]);
//        });

//        for ($i = 0; $i < 10; $i++) {
//            $user = factory(App\User::class)->create(['role_id' => 2]);
//            $organisation = factory(\App\Organisation::class)->create([
//                'director_id' => $user->id,
//            ]);
//        }

        $user = factory(App\User::class)->create([
            'role_id' => 2,
            'name' => 'Сасин Игорь Николаевич',
            'username' => 'sasin.igor',
        ]);
        $organisation = \App\Organisation::create([
            'full_name' => 'Муниципальное бюджетное общеобразовательное учреждение «Школа № 1 имени В.И. Муравленко»',
            'short_name' => 'МБОУ «Школа № 1 имени В.И. Муравленко»',
            'director_id' => $user->id,
            'reception' => 'Понедельник: 17:00 - 18:30',
            'legal_address' => '629601, Ямало-Ненецкий автономный округ, г. Муравленко, ул. Академика Губкина, д.42.',
            'actual_address' => '629601, Ямало-Ненецкий автономный округ, г. Муравленко, ул. Академика Губкина, д.42.',
            'phone' => '(34938)44220',
            'fax' => '(34938)44220',
            'email' => 'school1@muravlenko.yanao.ru',
            'website' => 'школа1ямал.рф',
            'is_school' => 1,
        ]);

        $user = factory(App\User::class)->create([
            'role_id' => 2,
            'name' => 'Зикирин Кайрат Маратович',
            'username' => 'zikirin.kairat',
        ]);
        $organisation = \App\Organisation::create([
            'full_name' => 'Муниципальное бюджетное общеобразовательное учреждение «Школа № 2»',
            'short_name' => 'МБОУ «Школа № 2»',
            'director_id' => $user->id,
            'reception' => 'Вторник: 17:00 - 18:00',
            'legal_address' => '629602, Ямало-Ненецкий автономный округ, г. Муравленко, ул. Дружбы Народов, д. 7.',
            'actual_address' => '629602, Ямало-Ненецкий автономный округ, г. Муравленко, ул. Дружбы Народов, д. 7.',
            'phone' => '(34938)56884',
            'email' => 'school2@muravlenko.yanao.ru',
            'website' => 'school2.uomur.org',
            'is_school' => 1,
        ]);

        $user = factory(App\User::class)->create([
            'role_id' => 2,
            'name' => 'Шишкина Наталья Николаевна',
            'username' => 'shishkina.natalia',
        ]);
        $organisation = \App\Organisation::create([
            'full_name' => 'Муниципальное бюджетное общеобразовательное учреждение «Школа № 3 имени А.И. Покрышкина»',
            'short_name' => 'МБОУ «Школа № 3 им. А.И. Покрышкина»',
            'director_id' => $user->id,
            'reception' => 'Понедельник - пятница: 14:00 - 17:00',
            'legal_address' => '629601, Ямало-Ненецкий автономный округ, г. Муравленко, ул. Школьная, д.17.',
            'actual_address' => '629601, Ямало-Ненецкий автономный округ, г. Муравленко, ул. Школьная, д.17.',
            'phone' => '(34938)56920',
            'email' => 'school3@muravlenko.yanao.ru',
            'website' => 'school3.uomur.org',
            'is_school' => 1,
        ]);

        $user = factory(App\User::class)->create([
            'role_id' => 2,
            'name' => 'Полевцова Ольга Борисовна',
            'username' => 'polevtsova.olga',
        ]);
        $organisation = \App\Organisation::create([
            'full_name' => 'Муниципальное бюджетное общеобразовательное учреждение «Школа № 4»',
            'short_name' => 'МБОУ «Школа № 4»',
            'director_id' => $user->id,
            'reception' => 'Вторник: 16:00 - 18:00',
            'legal_address' => '629603, Ямало-Ненецкий автономный округ, г. Муравленко, ул. Муравленко, д.20',
            'actual_address' => '629603, Ямало-Ненецкий автономный округ, г. Муравленко, ул. Муравленко, д.20',
            'phone' => '(34938)26405',
            'email' => 'school4@muravlenko.yanao.ru',
            'website' => 'school4mur.ru',
            'is_school' => 1,
        ]);

        $user = factory(App\User::class)->create([
            'role_id' => 2,
            'name' => 'Заболотских Максим Юрьевич',
            'username' => 'zabolotskih.maksim',
        ]);
        $organisation = \App\Organisation::create([
            'full_name' => 'Муниципальное бюджетное общеобразовательное учреждение «Школа № 5»',
            'short_name' => 'МБОУ «Школа № 5»',
            'director_id' => $user->id,
            'reception' => 'Вторник: 08:30 - 12:30; Суббота: 10:00 - 13:00',
            'legal_address' => '629603, Ямало-Ненецкий автономный округ, г.Муравленко, ул.Дружбы народов, д.104',
            'actual_address' => '629603, Ямало-Ненецкий автономный округ, г.Муравленко, ул.Дружбы народов, д.104',
            'phone' => '(34938)42505',
            'email' => 'school5@muravlenko.yanao.ru',
            'website' => 'http://school5.uomur.org/',
            'is_school' => 1,
        ]);

        $user = factory(App\User::class)->create([
            'role_id' => 2,
            'name' => 'Архипова Галина Евгеньевна',
            'username' => 'arkhipova.galina',
        ]);
        $organisation = \App\Organisation::create([
            'full_name' => 'Муниципальное бюджетное общеобразовательное учреждение «Школа № 6»',
            'short_name' => 'МБОУ «Школа № 6»',
            'director_id' => $user->id,
            'reception' => 'Суббота: 09:30 - 12:30',
            'legal_address' => '629601, Ямало-Ненецкий автономный округ, г. Муравленко, ул.Украинских строителей, д.10',
            'actual_address' => '629601, Ямало-Ненецкий автономный округ, г. Муравленко, ул.Украинских строителей, д.10',
            'phone' => '(34938)44066',
            'email' => 'school6@muravlenko.yanao.ru',
            'website' => 'школа6ямал.рф',
            'is_school' => 1,
        ]);

        $user = factory(App\User::class)->create([
            'role_id' => 2,
            'name' => 'Ермилова Анна Дмитриевна',
            'username' => 'ermilova.anna',
        ]);
        $organisation = \App\Organisation::create([
            'full_name' => 'Муниципальное бюджетное общеобразовательное учреждение «Многопрофильный лицей»',
            'short_name' => 'МБОУ «Многопрофильный лицей»',
            'director_id' => $user->id,
            'reception' => 'Понедельник - пятница: 14:00 - 17:00',
            'legal_address' => '629602, Ямало-Ненецкий автономный округ, г. Муравленко, ул. Пионерская, д.4.',
            'actual_address' => '629602, Ямало-Ненецкий автономный округ, г. Муравленко, ул. Пионерская, д.4.',
            'phone' => '(34938)23787',
            'fax' => '(34938)23787',
            'email' => 'ml@muravlenko.yanao.ru',
            'website' => 'murlicey.ru',
            'is_school' => 1,
        ]);

        $user = factory(App\User::class)->create([
            'role_id' => 2,
            'name' => 'Юханова Мария Валериановна',
            'username' => 'ukhanova.maria',
        ]);
        $organisation = \App\Organisation::create([
            'full_name' => 'Муниципальное бюджетное общеобразовательное учреждение «Прогимназия «Эврика»',
            'short_name' => 'МБОУ «Прогимназия «Эврика»',
            'director_id' => $user->id,
            'reception' => 'Суббота: 09:30 - 12:30',
            'legal_address' => '629603, Ямало-Ненецкий автономный округ, г.Муравленко, ул.Нефтяников, д.85',
            'actual_address' => '629603, Ямало-Ненецкий автономный округ, г.Муравленко, ул.Нефтяников, д.85',
            'phone' => '(34938)56630',
            'email' => 'evrika@muravlenko.yanao.ru',
            'website' => 'evrika.uomur.org',
            'is_school' => 1,
        ]);

        $user = factory(App\User::class)->create([
            'role_id' => 2,
            'name' => 'Ясевич Сергей Александрович',
            'username' => 'yasevich.sergei',
        ]);
        $organisation = \App\Organisation::create([
            'full_name' => 'Муниципальное автономное учреждение дополнительного образования «Центр детского творчества»',
            'short_name' => 'МАУДО «Центр детского творчества»',
            'director_id' => $user->id,
            'reception' => 'Понедельник: 16:00 - 18:00',
            'legal_address' => '629603, Ямало-Ненецкий автономный округ, г.Муравленко, ул. Губкина, д.14',
            'actual_address' => '629603, Ямало-Ненецкий автономный округ, г.Муравленко, ул. Губкина, д.14',
            'phone' => '(34938)25145',
            'fax' => '(34938)25145',
            'email' => 'cdt@muravlenko.yanao.ru',
            'website' => 'радугаямал.рф',
            'is_school' => 0,
        ]);

        $user = factory(App\User::class)->create([
            'role_id' => 2,
            'name' => 'Карпов Михаил Владимирович',
            'username' => 'karpov.mikhail',
        ]);
        $organisation = \App\Organisation::create([
            'full_name' => 'Муниципальное автономное учреждение дополнительного образования «Центр технического творчества»',
            'short_name' => 'МАУДО «Центр технического творчества»',
            'director_id' => $user->id,
            'reception' => 'Вторник: 10:00 - 17:00; Суббота: 10:00 - 12:00',
            'legal_address' => '629603, Ямало-Ненецкий автономный округ, г.Муравленко, ул. Губкина, д.40',
            'actual_address' => '629603, Ямало-Ненецкий автономный округ, г.Муравленко, ул. Губкина, д.40',
            'phone' => '(34938)44271',
            'email' => 'ctt@muravlenko.yanao.ru',
            'website' => 'ctt.uomur.org',
            'is_school' => 0,
        ]);
    }
}
