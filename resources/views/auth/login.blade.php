<x-guest-layout>
    <h2>Autorizācija</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input type="text" name="lietotajvards" id="lietotajvards" value="{{ old('lietotajvards') }}" class="@error('lietotajvards') has-error @enderror" required autocomplete="lietotajvards" autofocus placeholder="Lietotājvārds">
        @error('lietotajvards')
        <span class="error">{{ $message }}</span>
        @enderror
        <input type="password" name="password" id="password" class="@error('password') has-error @enderror" required autocomplete="current-password" placeholder="Parole">

        <button type="submit">Autorizēties</button>

        <div class="links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="underline text-sm">Aizmirsta parole?</a>
            @endif
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="underline text-sm">Reģistrēties</a>
            @endif
        </div>
    </form>
</x-guest-layout>
