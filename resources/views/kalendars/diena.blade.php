<x-app-layout>
    <x-slot name="search">
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Uzdevumi ar termiņu {{ $carbon->format('d.m.Y') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-6 text-gray-900">
            @include("laikauzskaite.uzdevumi", ['uzdevumi' => $uzdevumi, "projVad" => $projVad])
        </div>
    </div>
</x-app-layout>
