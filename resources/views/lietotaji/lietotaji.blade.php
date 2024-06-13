<x-app-layout>
    <x-slot name="search">
        <form method="GET" action="{{ route('lietotaji') }}">
            <input type="text" placeholder="Meklēt lietotāju" name="search" value="{{ request('search') }}"/>
        </form>
        <a href="{{ route('lietotaji.create') }}" class="button">Jauns lietotājs</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900">
                @if($lietotaji->isNotEmpty())
                    <table>
                        <thead>
                            <tr>
                                <th>Lietotāji</th>
                                <th>Projekti</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lietotaji as $lietotajs)
                                <tr>
                                    <td>{{ $lietotajs->vards }} {{ $lietotajs->uzvards }}</td>
                                    <td>
                                        {{ $lietotajs->projekti->map->projNos->join(', ') }}
                                    </td>
                                    <td class="actions row">
                                        <a href="{{ route('lietotaji.edit', ['ID_lietotajs' => $lietotajs->ID_lietotajs]) }}" class="button">
                                            Labot
                                        </a>
                                        <a href="{{ route('lietotaji.get.destroy', ['ID_lietotajs' => $lietotajs->ID_lietotajs]) }}" class="button">
                                            Dzest
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Nav neviena lietotāja</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
