<x-guest-layout>
    <h2>Reģistrēties</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <input type="text" name="lietotajvards" id="lietotajvards" value="{{ old('lietotajvards') }}" class="@error('lietotajvards') has-error @enderror" required autocomplete="lietotajvards" autofocus placeholder="Lietotājvārds">
        @error('lietotajvards')
        <span class="error">{{ $message }}</span>
        @enderror

        <input type="text" name="vards" id="vards" value="{{ old('vards') }}" class="@error('vards') has-error @enderror" required autocomplete="vards" autofocus placeholder="Vārds">
        @error('vards')
        <span class="error">{{ $message }}</span>
        @enderror

        <input type="text" name="uzvards" id="uzvards" value="{{ old('uzvards') }}" class="@error('uzvards') has-error @enderror" required autocomplete="uzvards" autofocus placeholder="Uzvārds">
        @error('uzvards')
        <span class="error">{{ $message }}</span>
        @enderror

        <input type="password" name="password" id="password" class="@error('password') has-error @enderror" required autocomplete="current-password" placeholder="Parole">
        @error('password')
        <span class="error">{{ $message }}</span>
        @enderror

        <input type="password" name="password_confirmation" id="password_confirmation" class="@error('password_confirmation') has-error @enderror" required autocomplete="current-password" placeholder="Parole atkārtoti">
        @error('password_confirmation')
        <span class="error">{{ $message }}</span>
        @enderror

        <label>
            <input type="checkbox" name="projvad" value="1"/>
            Esmu projektu vadītājs
        </label>

        <button type="submit">Reģistrēties</button>

        <div class="links">
            <a href="/" class="underline text-sm">Atpakaļ</a>
        </div>
    </form>
</x-guest-layout>
