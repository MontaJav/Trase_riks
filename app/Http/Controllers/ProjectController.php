<?php

namespace App\Http\Controllers;

use App\Models\ProjNosaukums;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $ID_projekts = $request->input('ID_projekts');
        $projVad = Auth::user()?->projVaditajs;

        if ($projVad) {
            $projekti = $projVad->projNosaukums;
        } else {
            $projekti = Auth::user()->lietotajs->projekti;
        }

        if ($ID_projekts) {
            $projekti = $projekti->filter(fn ($p) => $p->ID_projekts === $ID_projekts);
        }
        if ($search) {
            $projekti = $projekti->filter(fn ($p) => str_contains($p->projNos, $search));
        }

        return view('projekti.projekti', compact('projekti', 'projVad'));
    }

    public function store(Request $request, int $ID_projekts = null)
    {
        $projVad = Auth::user()?->projVaditajs;

        if (! $projVad) {
            return redirect('projekti');
        }

        $request->validate([
            'projNos' => 'required|unique:ProjNosaukums,projNos,' . $ID_projekts . ',ID_projekts',
        ]);

        if ($ID_projekts) {
            $projekts = ProjNosaukums::findOrFail($ID_projekts);
            $projekts->update($request->only('projNos'));
        } else {
            ProjNosaukums::create([
                'ID_vaditajs' => $projVad->ID_vaditajs,
                'regDatProj' => now(),
                'projNos' => $request->projNos,
            ]);
        }

        return redirect()->intended('projekti');
    }

    public function edit(int $ID_projekts)
    {
        $projekts = ProjNosaukums::findOrFail($ID_projekts);

        return view('projekti.form', compact('projekts'));
    }

    public function destroy(int $ID_projekts, Request $request)
    {
        $projekts = ProjNosaukums::findOrFail($ID_projekts);

        if ($request->isMethod('get')) {
            return view('projekti.delete', compact('projekts'));
        }

        $projekts->delete();

        return redirect('projekti');
    }

    public function uzdevumi(int $ID_projekts)
    {
        $projekts = ProjNosaukums::findOrFail($ID_projekts);
        $projVad = Auth::user()?->projVaditajs;

        return view('projekti.uzdevumi', compact('projekts', 'projVad'));
    }
}
