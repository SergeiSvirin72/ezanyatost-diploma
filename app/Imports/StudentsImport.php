<?php

namespace App\Imports;

use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class StudentsImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $rules = [
            'name' => 'required|min:2|max:50|alpha_space',
            'username' => 'required|min:2|max:50|alphanum_dot|unique:users',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|min:6',
            'gender' => 'required|exists:genders,name',
            'class' => 'required|numeric|min:1|max:11',
            'letter' => 'required|alpha|min:1|max:1',
            'organisation' => ['required', 'exists:organisations,short_name', function($attribute, $value, $fail) use ($rowIndex, $row) {
                $isSchool = \App\Organisation::where('short_name', $row['organisation'])->value('is_school');
                if (!$isSchool) $fail('Строка: '.$rowIndex.'. Выбранное значение для Учреждение ошибочно.');

                if ($hasOrganisation = request()->get('hasOrganisation')) {
                    $organisation = \App\Organisation::find($hasOrganisation)->value('short_name');
                    if ($value !== $organisation) $fail('Строка: '.$rowIndex.'. Выбранное значение для Учреждение ошибочно.');
                }
            }],
        ];

        $message = [
            'required' => 'Строка: '.$rowIndex.'. Поле :attribute обязательно для заполнения.',
            'gt'             => [
                'numeric' => 'Строка: '.$rowIndex.'. Поле :attribute должно быть больше :value.',
                'file'    => 'Строка: '.$rowIndex.'. Размер файла в поле :attribute должен быть больше :value Килобайт(а).',
                'string'  => 'Строка: '.$rowIndex.'. Количество символов в поле :attribute должно быть больше :value.',
                'array'   => 'Строка: '.$rowIndex.'. Количество элементов в поле :attribute должно быть больше :value.',
            ],
            'lt'       => [
                'numeric' => 'Строка: '.$rowIndex.'. Поле :attribute должно быть меньше :value.',
                'file'    => 'Строка: '.$rowIndex.'. Размер файла в поле :attribute должен быть меньше :value Килобайт(а).',
                'string'  => 'Строка: '.$rowIndex.'. Количество символов в поле :attribute должно быть меньше :value.',
                'array'   => 'Строка: '.$rowIndex.'. Количество элементов в поле :attribute должно быть меньше :value.',
            ],
            'alpha' => 'Строка: '.$rowIndex.'. Поле :attribute может содержать только буквы.',
            'alpha_space' => 'Строка: '.$rowIndex.'. Поле :attribute может содержать только буквы и пробелы.',
            'alphanum_dot' => 'Строка: '.$rowIndex.'. Поле :attribute может содержать только буквы, цифры и точки.',
            'unique' => 'Строка: '.$rowIndex.'. Такое значение поля :attribute уже существует.',
            'email' => 'Строка: '.$rowIndex.'. Поле :attribute должно быть действительным электронным адресом.',
            'exists' => 'Строка: '.$rowIndex.'. Выбранное значение для :attribute некорректно.',
            'in' => 'Строка: '.$rowIndex.'. Выбранное значение для :attribute ошибочно.',
            'numeric' => 'Строка: '.$rowIndex.'. Поле :attribute должно быть числом.',
        ];

        Validator::make($row, $rules, $message)->validate();

        $gender = \App\Gender::where('name', $row['gender'])->value('id');
        $organisation = \App\Organisation::where('short_name', $row['organisation'])->value('id');

        $user = \App\User::create([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => \Hash::make($row['password']),
            'username' => $row['username'],
            'role_id' => 5,
        ]);

        $student = \App\Student::create([
            'user_id' => $user->id,
            'gender_id' => $gender,
            'organisation_id' => $organisation,
            'class' => $row['class'],
            'letter' => $row['letter'],
        ]);
    }
}
