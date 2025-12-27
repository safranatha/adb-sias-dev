<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-2">
            <div class="relative h-30 p-6 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <flux:text>Hallo, selamat datang kembali 👋</flux:text>
                <h1 class="mt-2 font-bold text-4xl">{{ auth()->user()->name }}</h1>
            </div>
            <div class="relative h-30 p-6 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <flux:text>SPH yang harus diperiksa:</flux:text>
                <h1 class="mt-2 font-bold text-4xl">📚 6 Surat Penawaran Harga</h1>
            </div>
            
        </div>
        <div class="grid auto-rows-min gap-4 md:grid-cols-2">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <livewire:dashboard.chart />     
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <livewire:dashboard.ChartProposal />     
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <livewire:dashboard.ChartSph />     
            </div>
        </div>
        
    </div>
</x-layouts.app>
