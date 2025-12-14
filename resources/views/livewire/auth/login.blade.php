<x-layouts.auth>
    <div class="flex flex-col gap-8 w-full">
        <!-- Logo/Header Section -->
        <div class="text-center space-y-3">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">
                Tender Adi Banuwa
            </h1>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                Masukkan email dan password Anda untuk log in
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <!-- Form Card -->
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-xl border border-zinc-200 dark:border-zinc-800 p-8 w-full">
            <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
                @csrf

                <!-- Email Address -->
                <flux:field>
                    <flux:input
                        name="email"
                        :label="__('Alamat email')"
                        :value="old('email')"
                        type="email"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="email@example.com"
                        class="w-full"
                    />
                </flux:field>

                <!-- Password -->
                <flux:field>
                    <div class="flex items-center justify-between mb-2">
                        <flux:label>{{ __('Password') }}</flux:label>
                    </div>
                    <flux:input
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        :placeholder="__('Masukkan password')"
                        viewable
                        class="w-full"
                    />
                </flux:field>

                <!-- Remember Me -->
                {{-- <flux:checkbox name="remember" :label="__('Ingat saya')" :checked="old('remember')" /> --}}

                <!-- Submit Button -->
                <flux:button 
                    variant="primary" 
                    color="emerald" 
                    type="submit" 
                    class="w-full py-3 text-base font-semibold shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all" 
                    data-test="login-button"
                >
                    {{ __('Masuk') }}
                </flux:button>
            </form>
        </div>

        <!-- Register Link (if enabled) -->
        @if (Route::has('register'))
            {{-- <div class="text-center">
                <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Belum punya akun?') }}</span>
                <flux:link 
                    :href="route('register')" 
                    wire:navigate
                    class="ml-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400"
                >
                    {{ __('Daftar sekarang') }}
                </flux:link>
            </div> --}}
        @endif

        <!-- Footer -->
        <p class="text-xs text-center text-zinc-500 dark:text-zinc-500">
            © {{ date('Y') }} Adi Banuwa. All rights reserved.
        </p>
    </div>
</x-layouts.auth>