<?php

namespace App\Http\Controllers;

use App\Models\Autentifikacija;
use App\Models\Lietotajs;
use App\Models\ProjNosaukums;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $lietotaji = Lietotajs::all();

        if ($search = $request->input('search')) {
            $search = strtolower($search);
            $lietotaji = $lietotaji->filter(
                fn ($l) => str_contains(strtolower($l->vards), $search) || str_contains(strtolower($l->uzvards), $search));
        }

        return view('lietotaji.lietotaji', ['lietotaji' => $lietotaji]);
    }

    public function create()
    {
        return view('lietotaji.form', ['lietotajs' => null, 'projekti' => ProjNosaukums::all()]);
    }

    public function store(Request $request, $ID_lietotajs = null)
    {
        $lietotajs = $ID_lietotajs ? Lietotajs::findOrFail($ID_lietotajs) : null;

        $request->validate([
            'lietotajvards' => [
                'required',
                'string',
                'max:50',
                'unique:Autentifikacija,lietotajvards,' . $lietotajs?->ID_aut . ',ID_aut',
                'alpha_dash',
            ],
            'vards' => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z]+$/'],
            'uzvards' => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z]+$/'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $aut = Autentifikacija::updateOrCreate(
            ['lietotajvards' => $request->lietotajvards],
            [
                'lietotajvards' => $request->lietotajvards,
                'parole' => Hash::make($request->password),
            ]
        );

        $params = [
            'ID_aut' => $aut->ID_aut,
            'vards' => $request->vards,
            'uzvards' => $request->uzvards,
            'tiesibas' => 'lietotajs',
        ];

        if (!$ID_lietotajs) {
            $params['regDatLiet'] = now();
        }

        $lietotajs = Lietotajs::updateOrCreate(['ID_lietotajs' => $ID_lietotajs], $params);
        $lietotajs->projekti()->sync($request->projekti);

        return redirect()->route('lietotaji');
    }

    public function edit(int $ID_lietotajs)
    {
        $lietotajs = Lietotajs::findOrFail($ID_lietotajs);

        return view('lietotaji.form', ['lietotajs' => $lietotajs, 'projekti' => ProjNosaukums::all()]);
    }

    public function destroy(int $ID_lietotajs, Request $request)
    {
        $lietotajs = Lietotajs::findOrFail($ID_lietotajs);
        $aut = $lietotajs->autentifikacija;

        if ($request->isMethod('get')) {
            return view('lietotaji.delete', compact('lietotajs'));
        }

        $lietotajs->projekti()->detach();
        $lietotajs->delete();

        $aut->delete();

        return redirect('lietotaji');
    }
}
