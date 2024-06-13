<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Autentifikacija;
use App\Models\Lietotajs;
use App\Models\ProjVaditajs;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'lietotajvards' => ['required', 'string', 'max:50', 'unique:'.Autentifikacija::class, 'alpha_dash'],
            'vards' => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z]+$/'],
            'uzvards' => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z]+$/'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $aut = Autentifikacija::create([
            'lietotajvards' => $request->lietotajvards,
            'parole' => Hash::make($request->password),
        ]);

        if ($request->input('projvad')) {
            ProjVaditajs::create([
                'ID_aut' => $aut->ID_aut,
                'vards' => $request->vards,
                'uzvards' => $request->uzvards,
                'regDatVad' => now(),
            ]);
        } else {
            Lietotajs::create([
                'vards' => $request->vards,
                'uzvards' => $request->uzvards,
                'ID_aut' => $aut->ID_aut,
                'regDatLiet' => now(),
                'tiesibas' => 'lietotajs',
            ]);
        }

        event(new Registered($aut));

        Auth::login($aut);

        return redirect(RouteServiceProvider::HOME);
    }
}
