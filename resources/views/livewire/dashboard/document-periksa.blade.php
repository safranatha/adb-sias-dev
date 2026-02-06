<div>

@if (
    auth()->user()->hasRole('Manajer Teknik') ||
    auth()->user()->hasRole('Manajer Admin') ||
    auth()->user()->hasRole('Direktur')
)
    <div class="relative h-30 p-6 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">

        @if (auth()->user()->hasRole('Manajer Teknik'))
            <flux:text>Proposal yang harus diperiksa:</flux:text>
            <h2 class="mt-2 font-bold text-4xl">
                📚 {{ $proposal_periksa }} Proposal
            </h2>

        @elseif (auth()->user()->hasRole('Manajer Admin'))
            <flux:text>Surat Penawaran Harga yang harus diperiksa:</flux:text>
            <h2 class="mt-2 font-bold text-4xl">
                📚 {{ $sph_periksa }} Surat Penawaran Harga
            </h2>

        @elseif (auth()->user()->hasRole('Direktur'))
            <flux:text>Tender dalam status "Dalam Proses":</flux:text>
            <h2 class="mt-2 font-bold text-4xl">
                📚 {{ $tender_dalam_proses }} Tender
            </h2>
        @endif

    </div>
@endif

</div>
