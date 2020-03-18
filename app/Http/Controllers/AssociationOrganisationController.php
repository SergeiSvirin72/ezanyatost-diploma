<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssociationOrganisationController extends Controller
{
    public function index()
    {
        $relationships = \DB::table('association_organisation')
            ->join('associations',
                'association_organisation.association_id',
                '=',
                'associations.id')
            ->join('organisations',
                'association_organisation.organisation_id',
                '=',
                'organisations.id')
            ->select('association_organisation.*',
                'associations.name AS association',
                'organisations.short_name AS organisation')
            ->orderBy('organisations.id')
            ->paginate(20);

        return view('closed.admin.association_organisation.index', [
            'relationships' => $relationships,
        ]);
    }

    public function create()
    {
        $organisations = \App\Organisation::all();
        $associations = \App\Association::all();
        return view('closed.admin.association_organisation.create', [
            'associations' => $associations,
            'organisations' => $organisations,
        ]);
    }

    public function store()
    {
        $association_id = request()->input('association_id');
        $organisation_id = request()->input('organisation_id');

        $data = request()->validate([
            'association_id' => 'unique:association_organisation,association_id,NULL,id,organisation_id,' . $organisation_id,
            'organisation_id' => 'unique:association_organisation,organisation_id,NULL,id,association_id,' . $association_id,
        ]);

        $relationship = \App\AssociationOrganisation::create($data);

        return back()->with('success', 'Связь успешно добавлена');
    }

    public function destroy($id) {
        $relationship = \App\AssociationOrganisation::findOrFail($id);
        $relationship->delete();
        return back()->with('success', 'Связь успешно удалена');
    }
}
