<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(isset($lietotajs))
                Labot lietotāja informāciju
            @else
                Jauns lietotājs
            @endif
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('lietotaji.store', ['ID_lietotajs' => $lietotajs?->ID_lietotajs]) }}" class="forma">
        @csrf

        <input type="text" name="lietotajvards" id="lietotajvards" value="{{ $lietotajs?->autentifikacija->lietotajvards }}" class="@error('lietotajvards') has-error @enderror" required autocomplete="lietotajvards" autofocus placeholder="Lietotājvārds">
        @error('lietotajvards')
        <span class="error">{{ $message }}</span>
        @enderror

        <input type="text" name="vards" id="vards" value="{{ $lietotajs?->vards }}" class="@error('vards') has-error @enderror" required autocomplete="vards" autofocus placeholder="Vārds">
        @error('vards')
        <span class="error">{{ $message }}</span>
        @enderror

        <input type="text" name="uzvards" id="uzvards" value="{{ $lietotajs?->uzvards }}" class="@error('uzvards') has-error @enderror" required autocomplete="uzvards" autofocus placeholder="Uzvārds">
        @error('uzvards')
        <span class="error">{{ $message }}</span>
        @enderror

        <input type="password" name="password" id="password" class="@error('password') has-error @enderror" required placeholder="Parole">
        @error('password')
        <span class="error">{{ $message }}</span>
        @enderror

        <input type="password" name="password_confirmation" id="password_confirmation" class="@error('password_confirmation') has-error @enderror" required placeholder="Parole atkārtoti">
        @error('password_confirmation')
        <span class="error">{{ $message }}</span>
        @enderror

        <p>Piesaistīt projektiem:</p>
        @foreach($projekti as $projekts)
            <div>
                <label>
                    <input type="checkbox" name="projekti[]" value="{{ $projekts->ID_projekts }}"
                           @if($lietotajs?->projekti->pluck('ID_projekts')->contains($projekts->ID_projekts)) checked @endif
                    />
                    {{ $projekts->projNos }}
                </label>
            </div>
        @endforeach

        <button type="submit" class="button">Saglabāt</button>
    </form>
</x-app-layout>
