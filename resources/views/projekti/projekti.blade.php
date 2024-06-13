<x-app-layout>
    <x-slot name="search">
        <form method="GET" action="{{ route('projekti') }}">
            <input type="text" placeholder="Meklēt projektu" name="search" value="{{ request('search') }}"/>
        </form>
        @if($projVad)
            <a href="{{ route('projekti.create') }}" class="button">Jauns projekts</a>
        @endif
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mani projekti
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900">
                @if($projekti->isNotEmpty())
                    <table>
                        <tbody>
                            @foreach($projekti as $projekts)
                                <tr>
                                    <td>{{ $projekts->projNos }}</td>
                                    <td class="actions row">
                                        @if($projVad)
                                            <a href="{{ route('projekti.edit', ['ID_projekts' => $projekts->ID_projekts]) }}" class="button">
                                                Labot
                                            </a>
                                            <a href="{{ route('projekti.get.destroy', ['ID_projekts' => $projekts->ID_projekts]) }}" class="button">
                                                Dzest
                                            </a>
                                        @endif
                                        <a href="{{ route('projekti.uzdevumi', ['ID_projekts' => $projekts->ID_projekts]) }}" class="button">
                                            Uzdevumi
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>
                        @if($projVad)
                            Nav neviena projekta
                        @else
                            Nav pievienots neviens projekts
                        @endif
                    </p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
