<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(isset($uzdevums))
                @if($projVad)
                    Labot uzdevuma informāciju
                @else
                    {{ $uzdevums?->uzdTips }} {{ $uzdevums->uzdNos }} ({{ $uzdevums->projNosaukums->projNos }})
                @endif
            @else
                Jauns uzdevums
            @endif
        </h2>
    </x-slot>

    <form method="POST" enctype="multipart/form-data" action="{{ route('uzdevumi.store', ['ID_uzdevums' => $uzdevums?->ID_uzdevums]) }}" class="forma">
        @csrf

        @if($projVad)
            <input type="text" name="uzdNos" required placeholder="Uzdevuma nosaukums" value="{{ $uzdevums?->uzdNos }}"/>
            @error('projNos')
            <p>{{ $message }}</p>
            @enderror
        @else
            <input type="hidden"  name="uzdNos" value="{{ $uzdevums?->uzdNos }}"/>
        @endif


        @if($projVad)
            <datalist id="tipi">
                @foreach($tipi as $tips)
                    <option value="{{ $tips }}">
                @endforeach
            </datalist>
            <input type="text" list="tipi" name="uzdTips" value="{{ $uzdevums?->uzdTips }}" placeholder="Uzdevuma tips" required />
            @error('uzdTips')
            <p>{{ $message }}</p>
            @enderror
        @else
            <input type="hidden" name="uzdTips" value="{{ $uzdevums?->uzdTips }}"/>
        @endif

        @include('uzdevumi.statuss', ['statusi' => $statusi, 'uzdevums' => $uzdevums])

        <select name="uzdIp">
            <option value="" disabled @if(!$uzdevums)selected @endif>Piešķirt</option>
            @foreach($lietotaji as $id => $vards)
                <option value="{{ $id }}"
                        @if($uzdevums && $uzdevums->uzdIp == $id) selected @endif>
                    {{ $vards }}
                </option>
            @endforeach
        </select>
        @error('uzdIp')
        <p>{{ $message }}</p>
        @enderror

        @if($projVad)
            <input type="datetime-local" name="termins" value="{{ $uzdevums?->termins }}" placeholder="Izpildes termiņš">
            @error('termins')
            <p>{{ $message }}</p>
            @enderror
        @else
            <input type="hidden" name="termins" value="{{ $uzdevums->termins }}"/>
            <p>Izpildes termiņš: {{ $uzdevums->termins }}</p>
            <br>
        @endif

        @if($projVad)
            <select name="ID_projekts" required>
                <option value="" disabled @if(!$uzdevums)selected @endif>Izvēlies projektu</option>
                @foreach($projekti as $projekts)
                    <option value="{{ $projekts->ID_projekts }}"
                            @if($uzdevums && $uzdevums->ID_projekts == $projekts->ID_projekts) selected @endif>
                        {{ $projekts->projNos }}
                    </option>
                @endforeach
            </select>
            @error('ID_projekts')
            <p>{{ $message }}</p>
            @enderror
        @else
            <input type="hidden" name="ID_projekts" value="{{ $uzdevums?->ID_projekts }}"/>
        @endif

        @if($projVad)
            <textarea name="apraksts" required placeholder="Uzdevuma apraksts" rows="5">{{ $uzdevums?->uzdApraksts->aprTeksts }}</textarea>
            @error('apraksts')
            <p>{{ $message }}</p>
            @enderror
        @else
            <input type="hidden" name="apraksts" value="{{ $uzdevums->uzdApraksts->aprTeksts }}"/>
            <p>{{ $uzdevums->uzdApraksts->aprTeksts }}</p>
            <br>
        @endif

        @include('uzdevumi.pielikumi', ['uzdevums' => $uzdevums])
        @include('uzdevumi.komentari', ['uzdevums' => $uzdevums])

        <button type="submit" class="button">Saglabāt</button>
    </form>
</x-app-layout>
