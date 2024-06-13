<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(isset($projekts))
                Labot projekta informāciju
            @else
                Jauns projekts
            @endif
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('projekti.store', ['ID_projekts' => $projekts?->ID_projekts]) }}" class="forma">
        @csrf
        <input type="text" name="projNos" required placeholder="Projekta nosaukums" value="{{ $projekts?->projNos }}"/>
        @error('projNos')
            <p>{{ $message }}</p>
        @enderror

        <button type="submit" class="button">Saglabāt</button>
    </form>
</x-app-layout>
