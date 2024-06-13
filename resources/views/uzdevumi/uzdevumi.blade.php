<x-app-layout>
    <x-slot name="search">
        <form method="GET" action="{{ route('uzdevumi') }}">
            <input type="text" placeholder="Meklēt uzdevumu" name="search" value="{{ request('search') }}"/>
        </form>
        <a href="{{ route('uzdevumi.createOrEdit') }}" class="button">Jauns uzdevums</a>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Uzdevumu panelis
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900">
                @if($uzdevumi->isNotEmpty())
                    <table>
                        <thead>
                            <tr>
                                <th>Projekta nosaukums</th>
                                <th>Uzdevuma nr.</th>
                                <th>Uzdevuma tips</th>
                                <th>Uzdevuma nosaukums</th>
                                <th>Uzdevuma statuss</th>
                                <th>Reģistrācijas datums</th>
                                <th>Izpildes termiņš</th>
                                <th>Uzdevuma īpašnieks</th>
                                <th>Uzdevuma izpildītājs</th>
                                <th></th>
                            </tr>
                        </thead>
                        @foreach($uzdevumi as $uzdevums)
                            <tr>
                                <td>{{ $uzdevums->projNosaukums->projNos }}</td>
                                <td>{{ $uzdevums->ID_uzdevums }}</td>
                                <td>{{ $uzdevums->uzdTips }}</td>
                                <td>{{ $uzdevums->uzdNos }}</td>
                                <td>{{ $uzdevums->uzdStat }}</td>
                                <td>{{ $uzdevums->veidDat }}</td>
                                <td>{{ $uzdevums->termins ?? '-' }}</td>
                                <td>{{ $uzdevums->ipasnieks->vardsUzvards }}</td>
                                <td>{{ $uzdevums->izpilditajs?->lietotajs->vardsUzvards ?? '-' }}</td>
                                <td class="actions">
                                    @if($projVad || $uzdevums->uzdIp == request()->user()->ID_aut)
                                        <a href="{{ route('uzdevumi.createOrEdit', ['ID_uzdevums' => $uzdevums->ID_uzdevums]) }}" class="button">
                                            Labot
                                        </a>
                                    @endif
                                    @if($projVad)
                                        <a href="{{ route('uzdevumi.get.destroy', ['ID_uzdevums' => $uzdevums->ID_uzdevums]) }}" class="button">
                                            Dzest
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p>
                        @if(request()->user()->projVaditajs)
                            Nav neviena uzdevuma
                        @else
                            Nav pievienots neviens uzdevums
                        @endif
                    </p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
