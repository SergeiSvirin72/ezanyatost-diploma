<?php

namespace App\Imports;

use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TeachersImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        //$organisation = \App\Organisation::where('full_name', $row['organisation'])->value('id');
        $rules = [
            'name' => 'required|min:2|max:50|alpha_space',
            'username' => 'required|min:2|max:50|alphanum_dot|unique:users',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|min:6',
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
            ]
        ];

        $message = [
            'required' => 'Строка: '.$rowIndex.'. Поле :attribute обязательно для заполнения.',
            'min' => 'Строка: '.$rowIndex.'. Количество символов в поле :attribute должно быть меньше :value.',
            'max' => 'Строка: '.$rowIndex.'. Количество символов в поле :attribute не может превышать :max.',
            'alpha_space' => 'Строка: '.$rowIndex.'. Поле :attribute может содержать только буквы и пробелы.',
            'alphanum_dot' => 'Строка: '.$rowIndex.'. Поле :attribute может содержать только буквы, цифры и точки.',
            'unique' => 'Строка: '.$rowIndex.'. Такое значение поля :attribute уже существует.',
            'email' => 'Строка: '.$rowIndex.'. Поле :attribute должно быть действительным электронным адресом.',
            'exists' => 'Строка: '.$rowIndex.'. Выбранное значение для :attribute некорректно.',
            'in' => 'Строка: '.$rowIndex.'. Выбранное значение для :attribute ошибочно.',
        ];

        Validator::make($row, $rules, $message)->validate();

        $association = \DB::table('associations')
            ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
            ->where([
                ['organisations.short_name', $row['organisation']],
                ['associations.name', $row['association']],
            ])
            ->value('associations.id');

        $user = \App\User::create([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => \Hash::make($row['password']),
            'username' => $row['username'],
            'role_id' => 3,
        ]);

        $teacher = \App\Teacher::create([
            'user_id' => $user->id,
            'association_id' => $association,
        ]);
    }
}
