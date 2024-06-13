<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(isset($laikauzskaite))
                Labot ierakstu
            @else
                Jauns ieraksts
            @endif
             uzdevumam {{ $uzdevums->ID_uzdevums }}. {{ $uzdevums->uzdNos }} ({{ $uzdevums->projNosaukums->projNos }})
        </h2>
    </x-slot>

    <form method="POST" enctype="multipart/form-data"
          action="{{ route('laikauzskaite.store', ['ID_laikauzsk' => $laikauzskaite?->ID_laikauzsk, 'ID_uzdevums' => $uzdevums->ID_uzdevums]) }}"
          class="forma"
    >
        @csrf

        <input type="datetime-local" name="sakDatLaiks" value="{{ $laikauzskaite?->sakDatLaiks }}" required placeholder="Sākuma datums"/>
        @error('sakDatLaiks')
            <p class="error">{{ $message }}</p>
        @enderror

        <input type="datetime-local" name="beigDatLaiks" value="{{ $laikauzskaite?->beigDatLaiks }}" required placeholder="Beigu datums"/>
        @error('beigDatLaiks')
            <p class="error">{{ $message }}</p>
        @enderror

        @include('uzdevumi.statuss', ['statusi' => $statusi, 'uzdevums' => $uzdevums])
        @include('uzdevumi.pielikumi', ['uzdevums' => $uzdevums])
        @include('uzdevumi.komentari', ['uzdevums' => $uzdevums])

        <button type="submit" class="button">Saglabāt</button>
    </form>
</x-app-layout>
