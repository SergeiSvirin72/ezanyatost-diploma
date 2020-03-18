<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganisationController extends Controller
{
    public function index()
    {
        $organisations = \App\Organisation::paginate(10);
        return view('closed.admin.organisations.index', [
            'organisations' => $organisations
        ]);
    }

    public function create()
    {
        return view('closed.admin.organisations.create');
    }

    public function store()
    {
        $data = request()->validate([
            'full_name' => 'required',
            'short_name' => 'required',
            'director' => 'required|alpha_space',
            'reception' => 'required',
            'legal_address' => 'required',
            'actual_address' => 'required',
            'phone' => 'required|phone',
            'fax' => 'nullable|phone',
            'email' => 'required|email',
            'website' => 'required',
            'img' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data['is_school'] = (boolean)request()->input('is_school');

        $organisation = \App\Organisation::create($data);

        if (request()->has('img')) {
            $path = request()->file('img')->store('public/organisations');
            $path = explode('/', $path);
            unset($path[0]);
            $path = implode('/', $path);

        } else {
            $path = null;
        }
        $organisation->update(['img' => $path]);

        return back()->with('success', 'Учреждение успешно добавлено');
    }

    public function show($id) {
        $organisation = \App\Organisation::findOrFail($id);
        return view('closed.admin.organisations.show', [
            'organisation' => $organisation
        ]);
    }

    public function edit($id) {
        $organisation = \App\Organisation::findOrFail($id);
        return view('closed.admin.organisations.edit', [
            'organisation' => $organisation
        ]);
    }

    public function update($id) {
        $organisation = \App\Organisation::findOrFail($id);

        $data = request()->validate([
            'full_name' => 'required',
            'short_name' => 'required',
            'director' => 'required|alpha_space',
            'reception' => 'required',
            'legal_address' => 'required',
            'actual_address' => 'required',
            'phone' => 'required|phone',
            'fax' => 'nullable|phone',
            'email' => 'required|email',
            'website' => 'required',
            'img' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (request()->has('img')) {
            $path = request()->file('img')->store('public/organisations');
            $path = explode('/', $path);
            unset($path[0]);
            $path = implode('/', $path);
            $data['img'] = $path;
        }
        $data['is_school'] = (boolean)request()->input('is_school');

        $organisation->update($data);

        return back()->with('success', 'Учреждение успешно отредактировано');
    }

    public function destroy($id) {
        $organisation = \App\Organisation::findOrFail($id);
        if ($organisation->img) {
            \Storage::delete('/public/'.$organisation->img);
        }

        $organisation->delete();
        return back()->with('success', 'Учреждение успешно удалено');
    }

    public function delete_image($id) {
        $organisation = \App\Organisation::findOrFail($id);
        \Storage::delete('/public/'.$organisation->img);
        $organisation->update(['img' => null]);
        return back();
    }
}
