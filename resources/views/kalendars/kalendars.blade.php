<x-app-layout>
    <x-slot name="search">
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Uzdevumu kalendārs
        </h2>
    </x-slot>

    <div class="py-6 text-gray-900 kalendara-konteiners">
        <div class="kalendars">
            <div class="month">
                <ul>
                    <li class="prev">
                        <a href="{{ route('kalendars', ['date' => $prev]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                            </svg>
                        </a>
                    </li>
                    <li>{{ $monthName }} {{ $carbon->year }}</li>
                    <li class="next">
                        <a href="{{ route('kalendars', ['date' => $next]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>

            <ul class="weekdays">
                <li>P</li>
                <li>O</li>
                <li>T</li>
                <li>C</li>
                <li>P</li>
                <li>S</li>
                <li>Sv</li>
            </ul>

            <ul class="days">
                @for($i = 1; $i <= $carbon->daysInMonth; $i++)
                    @if($i === 1)
                        @for($j = 1; $j < $carbon->dayOfWeek; $j++)
                            <li></li>
                        @endfor
                    @endif
                    @php
                        $date = $carbon->year . "-" . str_pad($carbon->month, 2, 0, STR_PAD_LEFT) . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
                        $dienasUzdevumi = $uzdevumi->filter(function($uzdevums) use ($i) {
                            return $uzdevums->termins->day === $i;
                        });
                    @endphp
                    <li  class="@if($today === $date)active @endif @if($dienasUzdevumi->isNotEmpty()) uzdevumi @endif">
                        <a href="{{ route('kalendars.diena', ['diena' => $date]) }}">
                            {{ $i }}
                            @if($dienasUzdevumi->isNotEmpty())
                                <div class="alert" title="{{ $dienasUzdevumi->pluck('uzdNos')->implode(', ') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                    </svg>
                                </div>
                            @endif
                        </a>
                    </li>
                @endfor
            </ul>
        </div>

        <div class="uzdevumi">
            @if($uzdevumi->isNotEmpty())
                <h2>Uzdevumi šajā mēnesī</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Termiņš</th>
                            <th>Uzdevums</th>
                            <th>Statuss</th>
                            <th>Izpildītājs</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($uzdevumi as $uzdevums)
                            <tr>
                                <td>{{ $uzdevums->termins->format('d.m.Y H:i') }}</td>
                                <td>
                                    {{ $uzdevums->ID_uzdevums }}. {{ $uzdevums->uzdNos }} ({{ $uzdevums->projNosaukums->projNos }})
                                </td>
                                <td>{{ $uzdevums->uzdStat }}</td>
                                <td>{{ $uzdevums->izpilditajs->vardsUzvards }}</td>
                                <td>
                                    <a href="{{ route('laikauzskaite.uzdevums', ['ID_uzdevums' => $uzdevums->ID_uzdevums]) }}" class="button">
                                        Laika uzskaite
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Nav uzdevumu šajā mēnesī</p>
            @endif
        </div>
    </div>
</x-app-layout>
