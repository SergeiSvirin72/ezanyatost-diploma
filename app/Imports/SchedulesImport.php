<?php

namespace App\Imports;

use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class SchedulesImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $rules = [
            'organisation' => ['required', 'exists:organisations,short_name', function($attribute, $value, $fail) use ($rowIndex, $row) {
                if ($hasOrganisation = request()->get('hasOrganisation')) {
                    $organisation = \App\Organisation::find($hasOrganisation)->value('short_name');
                    if ($value !== $organisation) {
                        $fail('Строка: '.$rowIndex.'. Выбранное значение для Учреждение ошибочно.');
                    }
                }
            }],
            'association' => ['required', Rule::exists('associations', 'name')
                ->where(function ($query) use ($rowIndex, $row) {
                    $query->where('organisation_id', \App\Organisation::where('short_name', $row['organisation'])->value('id'));
                }),
            ],
            'teacher' => ['required', 'min:2', 'max:50', 'alpha_space', function($attribute, $value, $fail) use ($rowIndex, $row) {
                $teacher = \DB::table('teachers')
                    ->join('users', 'teachers.user_id', '=', 'users.id')
                    ->join('associations', 'teachers.association_id', '=', 'associations.id')
                    ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
                    ->where([
                        ['users.name', $row['teacher']],
                        ['associations.name', $row['association']],
                        ['organisations.short_name', $row['organisation']],
                    ])
                    ->when(request()->get('hasOrganisation'), function ($query, $hasOrganisation) {
                        $query->where('organisations.id', $hasOrganisation);
                    })
                    ->count();

                if (!$teacher) $fail('Строка: '.$rowIndex.'. Выбранное значение для Преподаватель ошибочно.');
            }],
            'weekday' => ['required', 'alpha', 'min:5', 'max:11', 'exists:weekdays,name'],
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i',
            'classroom' => 'required',
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

        $weekday = \App\Weekday::where('name', $row['weekday'])->value('id');
        $teacher = \DB::table('teachers')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->join('associations', 'teachers.association_id', '=', 'associations.id')
            ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
            ->where([
                ['users.name', $row['teacher']],
                ['associations.name', $row['association']],
                ['organisations.short_name', $row['organisation']],
            ])
            ->when(request()->get('hasOrganisation'), function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->value('teachers.id');

        $schedule = \App\Schedule::create([
            'teacher_id' => $teacher,
            'weekday_id' => $weekday,
            'start' => $row['start'],
            'end' => $row['end'],
            'classroom' => $row['classroom'],
        ]);
    }
}
