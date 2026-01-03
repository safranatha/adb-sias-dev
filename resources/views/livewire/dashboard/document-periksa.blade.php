{{-- <div> --}}
{{-- If your happiness depends on money, you will never be happy with yourself. --}}
{{-- </div> --}}

<div class="relative h-30 p-6 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
    {{-- <flux:text>SPH yang harus diperiksa:</flux:text>
    <h1 class="mt-2 font-bold text-4xl">📚 7 Surat Penawaran Harga</h1> --}}

    @if (auth()->user()->hasRole('Manajer Teknik'))
        <flux:text>Proposal yang harus diperiksa:</flux:text>
        <h1 class="mt-2 font-bold text-4xl">📚{{ $proposal_periksa }} Proposal</h1>
    @elseif (auth()->user()->hasRole('Manajer Admin'))
        <flux:text>Surat Penawaran Harga yang harus diperiksa:</flux:text>
        <h1 class="mt-2 font-bold text-4xl">📚{{ $sph_periksa }} Surat Penawaran Harga</h1>
    @elseif (auth()->user()->hasRole('Direktur'))
        <flux:text>Tender dalam status 'Dalam Proses':</flux:text>
        <h1 class="mt-2 font-bold text-4xl">📚{{ $tender_dalam_proses }} Tender</h1>
    @endif
</div>
