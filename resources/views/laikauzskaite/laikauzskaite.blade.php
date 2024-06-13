<x-app-layout>
    <x-slot name="search">
        <form method="GET" action="{{ route('laikauzskaite') }}">
            <input type="text" placeholder="Meklēt ierakstu" name="search" value="{{ request('search') }}"/>
        </form>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($projVad)
                Laika uzskaite
            @else
                Mani ieraksti
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900">
                @include("laikauzskaite.uzdevumi", ['uzdevumi' => $uzdevumi, "projVad" => $projVad])
            </div>
        </div>
    </div>
</x-app-layout>
