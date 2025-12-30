<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-zinc-50 dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-green-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="text-neutral-50 me-5 flex items-center space-x-2 rtl:space-x-reverse"
            wire:navigate>
            <x-app-logo />
            <!-- Dashboard Adibanuwa -->
        </a>

        <flux:navlist variant="outline" class="mt-5">
            <flux:navlist.group class="grid">
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    class="text-neutral-50" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>


        @if (auth()->user()->hasRole('Super Admin'))
            <flux:navlist variant="outline">
                <flux:navlist.group expandable :expanded="false" class="text-white">
                    <x-slot:heading>
                        <span class="text-white! font-medium">User Management</span>
                    </x-slot:heading>
                    <flux:navlist.item icon="plus-circle" :href="route('register')"
                        :current="request()->routeIs('register')" wire:navigate class="mt-2">
                        {{ __('Buat Pengguna Baru') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="user-group" :href="route('user-management.index')"
                        :current="request()->routeIs('user-management.index')" wire:navigate class="mt-2">
                        {{ __('Lihat Pengguna') }}
                    </flux:navlist.item>

                </flux:navlist.group>
            </flux:navlist>
        @endif

        @can('view tender')
            <flux:navlist variant="outline">
                <flux:navlist.group expandable :expanded="false" class="text-white">
                    <x-slot:heading>
                        <span class="text-white! font-medium">Tender</span>
                    </x-slot:heading>
                    <!-- Hanya direktur yang bisa membuat Tender -->
                    @can('create tender')
                        <flux:navlist.item icon="plus-circle" :href="route('tender.create')"
                            :current="request()->routeIs('tender.create')" wire:navigate class="mt-2">
                            {{ __('Buat Tender Baru') }}
                        </flux:navlist.item>
                    @endcan
                    <flux:navlist.item icon="clipboard-document-list" :href="route('tender.index')"
                        :current="request()->routeIs('tender.index')" wire:navigate class="mt-2">
                        {{ __('Daftar Tender') }}
                    </flux:navlist.item>

                </flux:navlist.group>
            </flux:navlist>
        @endcan

        @can('view proposal')
            <flux:navlist variant="outline">
                <flux:navlist.group expandable :expanded="false" class="text-white">
                    <x-slot:heading>
                        <span class="text-white! font-medium">Proposal</span>
                    </x-slot:heading>

                    @can('create proposal')
                        <flux:navlist.item icon="plus-circle" :href="route('proposal.create')"
                            :current="request()->routeIs('proposal.create')" wire:navigate class="mt-2">
                            {{ __('Buat Proposal Baru') }}
                        </flux:navlist.item>
                    @endcan

                    @if (!auth()->user()->hasRole('Manajer Admin'))
                        <flux:navlist.item icon="document-text" :href="route('proposal.active')"
                            :current="request()->routeIs('proposal.active')" wire:navigate class="mt-2">
                            {{ __('Daftar Proposal Aktif') }}
                        </flux:navlist.item>
                    @endif

                    <flux:navlist.item icon="clock" :href="route('proposal.index')"
                        :current="request()->routeIs('proposal.index')" wire:navigate class="mt-2">
                        {{ __('Riwayat Proposal') }}
                    </flux:navlist.item>

                </flux:navlist.group>
            </flux:navlist>
        @endcan

        @can('view surat penawaran harga')
            <flux:navlist variant="outline">
                <flux:navlist.group expandable :expanded="false" class="text-white">
                    <x-slot:heading>
                        <span class="text-white! font-medium">Surat Penawaran Harga</span>
                    </x-slot:heading>
                    @can('create surat penawaran harga')
                        <flux:navlist.item icon="plus-circle" :href="route('surat-penawaran-harga.create')"
                            :current="request()->routeIs('surat-penawaran-harga.create')" wire:navigate class="mt-2">
                            {{ __('Buat SPH Baru') }}
                        </flux:navlist.item>
                    @endcan
                    <flux:navlist.item icon="banknotes" :href="route('surat-penawaran-harga.active')"
                        :current="request()->routeIs('surat-penawaran-harga.active')" wire:navigate class="mt-2">
                        {{ __('Daftar SPH Aktif') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="clock" :href="route('surat-penawaran-harga.index')"
                        :current="request()->routeIs('surat-penawaran-harga.index')" wire:navigate class="mt-2">
                        {{ __('Riwayat SPH') }}
                    </flux:navlist.item>

                </flux:navlist.group>
            </flux:navlist>
        @endcan


        <flux:navlist variant="outline">
            <flux:navlist.group expandable :expanded="false" class="text-white">
                <x-slot:heading>
                    <span class="text-white! font-medium">Form Tugas</span>
                </x-slot:heading>

                @can('create form tugas')
                    <flux:navlist.item icon="plus-circle" :href="route('form-tugas.create')"
                        :current="request()->routeIs('form-tugas.create')" wire:navigate class="mt-2">
                        {{ __('Buat Form Tugas') }}
                    </flux:navlist.item>

                    <flux:navlist.item icon="document-minus" :href="route('form-tugas.index')"
                        :current="request()->routeIs('form-tugas.index')" wire:navigate class="mt-2">
                        {{ __('Riwayat Form Tugas') }}
                    </flux:navlist.item>
                @endcan

                @if(!auth()->user()->hasrole(['Direktur', 'Asisten Direktur']))
                    <flux:navlist.item icon="document-minus" :href="route('form-tugas.active')"
                        :current="request()->routeIs('form-tugas.active')" wire:navigate class="mt-2">
                        {{ __('Form Tugas Aktif') }}
                    </flux:navlist.item>
                @endif

            </flux:navlist.group>
        </flux:navlist>

        <flux:navlist variant="outline">
            <flux:navlist.group class="grid">
                <flux:navlist.item icon="magnifying-glass" :href="route('tracking-document.index')"
                    :current="request()->routeIs('tracking-document.index')" class="text-neutral-50" wire:navigate>
                    Tracking Dokumen</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />


        <!-- Desktop User Menu -->
        <flux:dropdown class="hidden lg:block" position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon:trailing="chevrons-up-down" data-test="sidebar-menu-button" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full"
                        data-test="logout-button">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full"
                        data-test="logout-button">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    {{-- Stack untuk Livewire / Chart --}}
    @stack('scripts')

    @fluxScripts
</body>

</html>