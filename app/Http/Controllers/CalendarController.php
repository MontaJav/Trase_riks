<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $today = date('Y-m-d');
        $carbon = (new Carbon($request->date))->startOfMonth();
        $prev = $carbon->copy()->subMonth()->toDateString();
        $next = $carbon->copy()->addMonth()->toDateString();

        $monthNames = [
            'Janvāris',
            'Februāris',
            'Marts',
            'Aprīlis',
            'Maijs',
            'Jūnijs',
            'Jūlijs',
            'Augusts',
            'Septembris',
            'Oktobris',
            'Novembris',
            'Decembris',
        ];
        $monthName = $monthNames[$carbon->month - 1];

        $projVad = Auth::user()?->projVaditajs;

        if ($projVad) {
            $uzdevumi = $projVad->projNosaukums->map->uzdevumi->flatten();
        } else {
            $uzdevumi = Auth::user()->uzdevumi;
        }

        $uzdevumi = $uzdevumi->filter(function ($uzdevums) use ($carbon) {
            return $uzdevums->termins->isSameMonth($carbon);
        })->sortBy('termins');

        return view(
            'kalendars.kalendars',
            compact('uzdevumi', 'carbon', 'monthName', 'today', 'prev', 'next')
        );
    }

    public function diena(string $diena)
    {
        $carbon = new Carbon($diena);

        $projVad = Auth::user()?->projVaditajs;

        if ($projVad) {
            $uzdevumi = $projVad->projNosaukums->map->uzdevumi->flatten();
        } else {
            $uzdevumi = Auth::user()->uzdevumi;
        }

        $uzdevumi = $uzdevumi->filter(function ($uzdevums) use ($carbon) {
            return $uzdevums->termins->isSameDay($carbon);
        });

        return view('kalendars.diena', compact('uzdevumi', 'carbon', 'projVad'));
    }
}
