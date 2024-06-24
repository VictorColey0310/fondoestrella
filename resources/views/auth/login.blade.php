<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-2 py-1 rounded relative mb-2 text-sm" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Documento -->
        <div>
            <x-input-label for="documento" :value="__('Documento')" />
            <x-text-input id="documento" class="block mt-1 w-full" type="text" name="documento" :value="old('documento')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('documento')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Olvidaste tu contraseña?') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Iniciar sesión') }}
            </x-primary-button>
        </div>
    </form>
    @if ($_SERVER['HTTP_HOST'] == 'silvia.rampint.com')
        <a target="_blank" href="{{ asset( App\Models\Informacion::first()->instructivo) }}">
            <x-primary-button class="mt-2">Descargar Instructivo</x-primary-button>
        </a>
    @endif

</x-guest-layout>
