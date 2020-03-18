<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssociationController extends Controller
{
    public function index()
    {
        $associations = \DB::table('associations')
            ->join('courses',
                'associations.course_id',
                '=',
                'courses.id')
            ->select('associations.*',
                'courses.name AS course')
            ->paginate(10);

        return view('closed.admin.associations.index', [
            'associations' => $associations,
        ]);
    }

    public function create()
    {
        $courses = \App\Course::all();
        return view('closed.admin.associations.create', [
            'courses' => $courses,
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required|alpha_space|unique:associations',
            'course_id' => 'required',
        ]);
        $association = \App\Association::create($data);

        return back()->with('success', 'Объединение успешно добавлено');
    }

    public function destroy($id) {
        $association = \App\Association::findOrFail($id);
        $association->delete();
        return back()->with('success', 'Объединение успешно удалено');
    }
}
