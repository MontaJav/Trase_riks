<x-app-layout>
    <x-slot name="search">
        <form method="GET" action="{{ route('laikauzskaite') }}">
            <input type="text" placeholder="Meklēt ierakstu" name="search" value="{{ request('search') }}"/>
        </form>
        <a href="{{ route('laikauzskaite.createOrEdit', ['ID_uzdevums' => $uzdevums]) }}" class="button">Jauns ieraksts</a>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $uzdevums->uzdNos }} laika uzskaites ieraksti
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900">
                @if($uzdevums->laikauzsk->isNotEmpty())
                    <table>
                        <thead>
                        <tr>
                            <th>Ieraksta nr.</th>
                            <th>No</th>
                            <th>Līdz</th>
                            <th>Laiks</th>
                            <th>Izveidoja</th>
                            <th></th>
                        </tr>
                        </thead>
                        @foreach($uzdevums->laikauzsk as $ieraksts)
                            <tr>
                                <td>{{ $ieraksts->ID_laikauzsk }}</td>
                                <td>{{ $ieraksts->sakDatLaiks }}</td>
                                <td>{{ $ieraksts->beigDatLaiks }}</td>
                                <td>{{ $ieraksts->laiks }}</td>
                                <td>{{ $ieraksts->autentifikacija->vardsUzvards }}</td>
                                @if($ieraksts->ID_aut == request()->user()->ID_aut)
                                    <td class="actions">
                                        <a href="{{ route('laikauzskaite.createOrEdit', ['ID_laikauzsk' => $ieraksts->ID_laikauzsk, 'ID_uzdevums' => $uzdevums]) }}" class="button">
                                            Labot
                                        </a>
                                        <a href="{{ route('laikauzskaite.get.destroy', ['ID_laikauzsk' => $ieraksts->ID_laikauzsk]) }}" class="button">
                                            Dzest
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p>
                        Nav neviena laika uzskaites ieraksta
                    </p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
