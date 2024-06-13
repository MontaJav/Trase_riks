<x-guest-layout>
    <h2>Atjaunot paroli</h2>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <input type="email" name="email" id="email" value="{{ old('email') }}" class="@error('email') has-error @enderror" required autocomplete="email" autofocus placeholder="E-pasts">
        @error('email')
        <span class="error">{{ $message }}</span>
        @enderror

        <button type="submit">Nosūtīt paroles atjaunošanas saiti</button>

        <div class="links">
            <a href="/" class="underline text-sm">Atpakaļ</a>
        </div>
    </form>
</x-guest-layout>
