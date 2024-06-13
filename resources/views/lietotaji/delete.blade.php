<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tiešām dzēst {{ $lietotajs->vards }} {{ $lietotajs->uzvards }}?
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('lietotaji.destroy', ['ID_lietotajs' => $lietotajs->ID_lietotajs]) }}" class="forma">
        @csrf
        <a href="{{ route('lietotaji') }}" class="button">Atcelt</a>
        <button type="submit" class="button">Dzēst</button>
    </form>
</x-app-layout>
