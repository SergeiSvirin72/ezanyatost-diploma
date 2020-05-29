<?php

namespace App\Imports;

use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class InvolvementsImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $rules = [
            'name' => ['required', 'min:2', 'max:50', 'alpha_space', function($attribute, $value, $fail) use ($rowIndex, $row) {
                $student = \DB::table('students')
                    ->join('users', 'students.user_id', '=', 'users.id')
                    ->join('organisations', 'students.organisation_id', '=', 'organisations.id')
                    ->where([
                        ['users.name', $row['name']],
                        ['students.letter', $row['letter']],
                        ['students.class', $row['class']],
                        ['organisations.short_name', $row['school']],
                    ])
                    ->count();

                if (!$student) $fail('Строка: '.$rowIndex.'. Выбранное значение для Обучающийся ошибочно.');
            }],
            'class' => 'required|numeric|min:1|max:11',
            'letter' => 'required|alpha|min:1|max:1',
            'school' => ['required', 'exists:organisations,short_name', function($attribute, $value, $fail) use ($rowIndex, $row) {
                $isSchool = \App\Organisation::where('short_name', $row['school'])->value('is_school');
                if (!$isSchool) $fail('Строка: '.$rowIndex.'. Выбранное значение для Учреждение ошибочно.');

                if ($hasOrganisation = request()->get('hasOrganisation')) {
                    $organisation = \App\Organisation::find($hasOrganisation)->value('short_name');
                    if ($value !== $organisation) $fail('Строка: '.$rowIndex.'. Выбранное значение для Учреждение ошибочно.');
                }
            }],
            'organisation' => ['required', 'exists:organisations,short_name'],
            'association' => ['required', function($attribute, $value, $fail) use ($rowIndex, $row) {
                $association = \DB::table('associations')
                    ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
                    ->where([
                        ['associations.name', $row['association']],
                        ['organisations.short_name', $row['organisation']],
                    ])
                    ->count();

                if (!$association) $fail('Строка: '.$rowIndex.'. Выбранное значение для Объединение ошибочно.');
            }],
        ];

        $message = [
            'required' => 'Строка: '.$rowIndex.'. Поле :attribute обязательно для заполнения.',
            'min' => 'Строка: '.$rowIndex.'. Количество символов в поле :attribute должно быть меньше :value.',
            'max' => 'Строка: '.$rowIndex.'. Количество символов в поле :attribute не может превышать :max.',
            'alpha' => 'Строка: '.$rowIndex.'. Поле :attribute может содержать только буквы.',
            'alpha_space' => 'Строка: '.$rowIndex.'. Поле :attribute может содержать только буквы и пробелы.',
            'alphanum_dot' => 'Строка: '.$rowIndex.'. Поле :attribute может содержать только буквы, цифры и точки.',
            'unique' => 'Строка: '.$rowIndex.'. Такое значение поля :attribute уже существует.',
            'email' => 'Строка: '.$rowIndex.'. Поле :attribute должно быть действительным электронным адресом.',
            'exists' => 'Строка: '.$rowIndex.'. Выбранное значение для :attribute некорректно.',
            'in' => 'Строка: '.$rowIndex.'. Выбранное значение для :attribute ошибочно.',
            'date_format' => 'Строка: '.$rowIndex.'. Поле :attribute не соответствует формату Часы:Минуты.',
        ];

        Validator::make($row, $rules, $message)->validate();

        $student = \DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('organisations', 'students.organisation_id', '=', 'organisations.id')
            ->where([
                ['users.name', $row['name']],
                ['students.letter', $row['letter']],
                ['students.class', $row['class']],
                ['organisations.short_name', $row['school']],
            ])
            ->value('students.id');
        $association = \DB::table('associations')
            ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
            ->where([
                ['associations.name', $row['association']],
                ['organisations.short_name', $row['organisation']],
            ])->value('associations.id');

        $involvement = \App\Involvement::firstOrCreate([
            'student_id' => $student,
            'association_id' => $association,
        ]);
    }
}
