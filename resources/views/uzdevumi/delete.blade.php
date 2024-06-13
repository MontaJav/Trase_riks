<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tiešām dzēst {{ $projekts?->projNos }}?
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('projekti.destroy', ['ID_projekts' => $projekts?->ID_projekts]) }}" class="forma">
        @csrf
        <a href="{{ route('projekti') }}" class="button">Atcelt</a>
        <button type="submit" class="button">Dzēst</button>
    </form>
</x-app-layout>
