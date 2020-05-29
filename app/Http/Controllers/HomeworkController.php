<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    public function index()
    {
        $hasOrganisation = request()->get('hasOrganisation');
        $hasAssociation = request()->get('hasAssociation');

        $homeworks = \DB::table('homeworks')
            ->join('associations',
                'homeworks.association_id', '=', 'associations.id')
            ->join('organisations',
                'associations.organisation_id', '=', 'organisations.id')
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->when($hasAssociation, function ($query, $hasAssociation) {
                $query->where('associations.id', $hasAssociation);
            })
            ->where([
                ['homeworks.date', '>=', (new \DateTime())->modify('-7 day')->format('Y-m-d')],
                ['homeworks.date', '<=', (new \DateTime())->modify('+7 day')->format('Y-m-d')],
            ])
            ->select('associations.name AS association',
                'organisations.short_name AS organisation',
                'homeworks.id AS id', 'homeworks.date AS date', 'homeworks.value AS homework')
            ->orderBy('date', 'desc')
            ->orderBy('associations.name', 'desc')
            ->paginate(10);

        return view('closed.admin.homeworks.index', [
            'homeworks' => $homeworks,
        ]);
    }

    public function fetchData() {
        $hasOrganisation = request()->get('hasOrganisation');
        $hasAssociation = request()->get('hasAssociation');

        $homeworks = \DB::table('homeworks')
            ->join('associations',
                'homeworks.association_id', '=', 'associations.id')
            ->join('organisations',
                'associations.organisation_id', '=', 'organisations.id')
            ->where(function ($query) {
                $search = request()->get('search');

                $query->where('associations.name', 'like', '%'.$search.'%')
                    ->orWhere('organisations.short_name', 'like', '%'.$search.'%')
                    ->orWhere('homeworks.date', 'like', '%'.$search.'%')
                    ->orWhere('homeworks.value', 'like', '%'.$search.'%');
            })
            ->when(request()->get('start'), function ($query, $start) {
                $query->where('homeworks.date', '>=', new \DateTime($start));
            })
            ->when(request()->get('end'), function ($query, $end) {
                $query->where('homeworks.date', '<=', new \DateTime($end));
            })
            ->when($hasOrganisation, function ($query, $hasOrganisation) {
                $query->where('organisations.id', $hasOrganisation);
            })
            ->when($hasAssociation, function ($query, $hasAssociation) {
                $query->where('associations.id', $hasAssociation);
            })
            ->select('associations.name AS association',
                'organisations.short_name AS organisation',
                'homeworks.id AS id', 'homeworks.date AS date', 'homeworks.value AS homework')
            ->orderBy(request()->get('column_name'), request()->get('sort_type'))
            ->paginate(10);

        return view('closed.admin.homeworks.index_data', [
            'homeworks' => $homeworks,
        ])->render();
    }

    public function create()
    {
        $hasOrganisation = request()->get('hasOrganisation');

        $organisations = \App\Organisation::when($hasOrganisation, function ($query, $hasOrganisation) {
            $query->where('id', $hasOrganisation);
        })->get();

        return view('closed.admin.homeworks.create', [
            'organisations' => $organisations,
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'organisation_id' => 'required',
            'association_id' => 'required',
            'date' => 'required|date_format:Y-m-d|after_or_equal:'.date('Y-m-d'),
            'value' => 'required',
            'materials' => 'nullable',
            'materials.*' => 'sometimes|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xls,xlsx,ppt,pptx|max:2048',
        ]);

        $homework = \App\Homework::create([
            'association_id' => $data['association_id'],
            'date' => $data['date'],
            'value' => $data['value'],
        ]);

        if (request()->has('materials')) {
            $materials = request()->file('materials');
            foreach ($materials as $material) {
                $path = $material->store('public/materials');
                $path = explode('/', $path);
                unset($path[0]);
                $path = implode('/', $path);

                \App\Material::create([
                    'homework_id' => $homework->id,
                    'link' => $path,
                ]);
            }
        }

        return back()->with('success', 'Запись успешно добавлена');
    }

    public function show($id) {
        if(!\DB::table('homeworks')->where('id', $id)->exists()) abort(404);

        $homework = \DB::table('homeworks')
            ->join('associations', 'homeworks.association_id', '=', 'associations.id')
            ->join('organisations', 'associations.organisation_id', '=', 'organisations.id')
            ->select('organisations.short_name AS organisation',
                'associations.name as association',
                'homeworks.*')
            ->where('homeworks.id', $id)
            ->first();

        $materials = \App\Material::where('homework_id', $id)->get();

        return view('closed.admin.homeworks.show', [
            'homework' => $homework,
            'materials' => $materials,
        ]);
    }

    public function fetchAssociations() {
        $hasAssociation = request()->get('hasAssociation');

        $associations = \DB::table('associations')
            ->when($hasAssociation, function ($query, $hasAssociation) {
                $query->where('associations.id', $hasAssociation);
            })
            ->where('associations.organisation_id', request()->input('values.0'))
            ->orderBy('associations.name', 'asc')
            ->get();

        return view('includes.options', [
            'options' => $associations,
            'name' => 'объединение',
        ]);
    }

    public function destroy($id) {
        $homework = \App\Homework::findOrFail($id);
        $homework->delete();
        return false;
    }
}
