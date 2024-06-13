<?php

namespace App\Http\Controllers;

use App\Models\LaikaUzskaite;
use App\Models\Uzdevumi;
use App\Models\UzdKomentari;
use App\Models\UzdPielikumi;
use App\Models\UzdStatusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TimeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $projVad = Auth::user()?->projVaditajs;

        if ($projVad) {
            $uzdevumi = $projVad->projNosaukums->map->uzdevumi->flatten();
        } else {
            $uzdevumi = Auth::user()->lietotajs->projekti->map->uzdevumi->flatten();
        }

        if ($search) {
            $uzdevumi = $uzdevumi->filter(
                fn ($p) => str_contains($p->uzdNos, $search)
                    || str_contains($p->uzdApraksts->apraksts, $search)
                    || str_contains($p->projNosaukums->nosaukums, $search)
            );
        }

        $uzdevumi->sort(
            fn($a, $b) => $a->laikauzsk->max('ID_laikauzsk') <=> $b->laikauzsk->max('ID_laikauzsk')
        );

        return view('laikauzskaite.laikauzskaite', compact('uzdevumi', 'projVad'));
    }

    public function createOrEdit(int $ID_uzdevums, ?int $ID_laikauzsk = null)
    {
        $laikauzskaite = $ID_laikauzsk ? LaikaUzskaite::find($ID_laikauzsk) : null;
        $statusi = UzdStatusi::all()->pluck('uzdStatuss');
        $uzdevums = Uzdevumi::find($ID_uzdevums);

        return view('laikauzskaite.form', compact('laikauzskaite', 'uzdevums', 'statusi'));
    }

    public function store(Request $request, int $ID_uzdevums, ?int $ID_laikauzsk = null)
    {
        $request->validate([
            'sakDatLaiks' => 'required',
            'beigDatLaiks' => 'required|after:sakDatLaiks',
        ]);

        LaikaUzskaite::updateOrCreate(
            ['ID_laikauzsk' => $ID_laikauzsk],
            [
                'ID_uzdevums' => $ID_uzdevums,
                'ID_aut' => Auth::id(),
                'sakDatLaiks' => $request->sakDatLaiks,
                'beigDatLaiks' => $request->beigDatLaiks,
            ]
        );

        Uzdevumi::where('ID_uzdevums', $ID_uzdevums)->update(['uzdStat' => $request->uzdStat]);

        if ($request->files->has('pielikumi')) {
            /** @var UploadedFile $file */
            foreach ($request->files->get('pielikumi') as $file) {
                $pielikums = UzdPielikumi::create([
                    'ID_aut' => Auth::id(),
                    'ID_uzdevums' => $ID_uzdevums,
                    'pielPievDat' => now(),
                    'pielNos' => time() . '.' . $file->getClientOriginalExtension(),
                ]);
                $file->move(public_path('uploads'), $pielikums->pielNos);
            }
        }

        if ($komentars = $request->komentars) {
            UzdKomentari::create([
                'ID_aut' => Auth::id(),
                'ID_uzdevums' => $ID_uzdevums,
                'komTeksts' => $komentars,
                'regDatKom' => now(),
            ]);
        }

        return redirect()->route('laikauzskaite.uzdevums', compact('ID_uzdevums'));
    }

    public function uzdevums(int $ID_uzdevums)
    {
        $uzdevums = Uzdevumi::find($ID_uzdevums);
        $projVad = Auth::user()?->projVaditajs;

        return view('laikauzskaite.uzdevums', compact('uzdevums', 'projVad'));
    }

    public function destroy(int $ID_laikauzsk)
    {
        LaikaUzskaite::destroy($ID_laikauzsk);

        return back();
    }
}
