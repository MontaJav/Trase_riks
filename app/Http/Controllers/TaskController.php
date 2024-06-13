<?php

namespace App\Http\Controllers;

use App\Models\Autentifikacija;
use App\Models\Lietotajs;
use App\Models\ProjLietotaji;
use App\Models\ProjNosaukums;
use App\Models\UzdApraksts;
use App\Models\Uzdevumi;
use App\Models\UzdKomentari;
use App\Models\UzdPielikumi;
use App\Models\UzdStatusi;
use App\Models\UzdTipi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $projVad = Auth::user()?->projVaditajs;

        if ($projVad) {
            $uzdevumi = $projVad->projNosaukums->map->uzdevumi->flatten();
        } else {
            $uzdevumi = Auth::user()->uzdevumi;
        }

        if ($search) {
            $uzdevumi = $uzdevumi->filter(
                fn ($p) => str_contains($p->uzdNos, $search)
                    || str_contains($p->uzdApraksts->apraksts, $search)
                    || str_contains($p->projNosaukums->nosaukums, $search)
            );
        }

        return view('uzdevumi.uzdevumi', compact('uzdevumi', 'projVad'));
    }

    public function createOrEdit(?int $ID_uzdevums = null)
    {
        $projVad = Auth::user()?->projVaditajs;
        $uzdevums = $ID_uzdevums ? Uzdevumi::findOrFail($ID_uzdevums) : null;

        if ($projVad) {
            $lietotaji = Lietotajs::all()->pluck('vardsUzvards', 'ID_aut')->sort();
        } else {
            $lietotaji = collect([$uzdevums->ipasnieks, Auth::user()->lietotajs])->pluck('vardsUzvards', 'ID_aut');
        }

        return view('uzdevumi.form', [
            'uzdevums' => $uzdevums,
            'projekti' => $projVad ? $projVad->projNosaukums : Auth::user()->lietotajs->projekti,
            'tipi' => UzdTipi::all()->pluck('uzdTips'),
            'statusi' => UzdStatusi::all()->pluck('uzdStatuss'),
            'lietotaji' => $lietotaji,
            'projVad' => $projVad,
        ]);
    }

    public function store(Request $request, ?int $ID_uzdevums = null)
    {
        $request->validate([
            'ID_projekts' => 'required|exists:ProjNosaukums,ID_projekts',
            'uzdIp' => 'sometimes|exists:Autentifikacija,ID_aut',
            'uzdTips' => 'required|string',
            'uzdNos' => 'required|string',
            'uzdStat' => 'required|string',
            'apraksts' => 'required|string'
        ]);

        if ($request->uzdIp) {
            $lietotajs = Autentifikacija::where('ID_aut', $request->uzdIp)->first()->lietotajs;

            if ($lietotajs) {
                $projNosaukums = ProjNosaukums::where(['ID_projekts' => $request->ID_projekts])->first();
                $projekts = ProjLietotaji::where([
                    'ID_projekts' => $request->ID_projekts,
                    'ID_lietotajs' => $lietotajs->ID_lietotajs,
                ])->first();

                if (!$projekts) {
                    return back()->withErrors(
                        ['uzdIp' => $lietotajs->vardsUzvards . ' nav piesaistīts projektam ' . $projNosaukums->projNos]
                    );
                }
            }
        }

        $uzdevums = $ID_uzdevums ? Uzdevumi::findOrFail($ID_uzdevums) : new Uzdevumi();
        $params = [
            'ID_projekts' => $request->ID_projekts,
            'uzdTips' => $request->uzdTips,
            'veidDat' => $ID_uzdevums ? $uzdevums->veidDat->format('Y-m-d H:i:s') : now(),
            'termins' => $request->termins,
            'uzdNos' => $request->uzdNos,
            'uzdStat' => $request->uzdStat,
            'uzdIp' => $request->uzdIp ?? Auth::id(),
            'uzdReg' => $ID_uzdevums ? $uzdevums->uzdReg : Auth::id(),
        ];
        $uzdevums->fill($params);
        $uzdevums->save();

        if ($ID_uzdevums) {
            UzdApraksts::where('ID_uzdevums', $ID_uzdevums)->update([
                'aprTeksts' => $request->apraksts,
                'red_datApr' => now(),
            ]);
        } else {
            UzdApraksts::create([
                'ID_uzdevums' => $uzdevums->ID_uzdevums,
                'aprTeksts' => $request->apraksts,
                'regDatApr' => now(),
            ]);
        }

        if ($request->files->has('pielikumi')) {
            /** @var UploadedFile $file */
            foreach ($request->files->get('pielikumi') as $file) {
                $pielikums = $uzdevums->uzdPielikumi()->create([
                    'ID_uzdevums' => $uzdevums->ID_uzdevums,
                    'ID_aut' => Auth::id(),
                    'pielPievDat' => now(),
                    'pielNos' => time() . '.' . $file->getClientOriginalExtension(),
                ]);
                $file->move(public_path('uploads'), $pielikums->pielNos);
            }
        }

        if ($komentars = $request->komentars) {
            UzdKomentari::create([
                'ID_aut' => Auth::id(),
                'ID_uzdevums' => $uzdevums->ID_uzdevums,
                'komTeksts' => $komentars,
                'regDatKom' => now(),
            ]);
        }

        UzdStatusi::updateOrCreate(['uzdStatuss' => $request->uzdStat]);
        UzdTipi::updateOrCreate(['uzdTips' => $request->uzdTips]);

        return redirect()->route('uzdevumi');
    }

    public function destroy(int $ID_uzdevums)
    {
        $uzdevums = Uzdevumi::findOrFail($ID_uzdevums);

        $uzdevums->uzdApraksts()->delete();
        $uzdevums->uzdKomentari()->delete();
        $uzdevums->uzdPielikumi()->delete();
        $uzdevums->delete();

        return redirect()->route('uzdevumi');
    }

    public function download(int $ID_pielikums)
    {
        $pielikums = UzdPielikumi::findOrFail($ID_pielikums);
        return response()->download(public_path('uploads/' . $pielikums->pielNos));
    }

    public function deleteAttachment(int $ID_pielikums)
    {
        UzdPielikumi::where('ID_pielikums', $ID_pielikums)->update(['pielDzesDat' => now()]);
        return back();
    }

    public function deleteComment(int $ID_komentars)
    {
        UzdKomentari::where('ID_komentars', $ID_komentars)->update(['dzesDatKom' => now()]);
        return back();
    }
}
