<div>
    <flux:heading size="xl">Detail Surat Penawaran Harga</flux:heading>
    <flux:text class="mt-2">Berikut merupakan detail Surat Penawaran Harga
        {{ $document_approvals->first()->name_tender_sph }}.</flux:text>

    @foreach ($document_approvals as $item)
        <div class="color-white bg-white p-10 rounded-lg shadow-md mt-6">
            <flux:heading size="lg">Status</flux:heading>
            <flux:text size="md" class="mt-2">{{ $item->status_proposal }}</flux:text>
    
            <flux:heading size="lg" class="mt-6">Validator</flux:heading>
            @if ($item->level === "3")
                <flux:text size="md" class="mt-2">Direktur</flux:text>
            @elseif ($item->level === "2")
                <flux:text size="md" class="mt-2">Manajer Admin</flux:text>
            @endif

            <flux:heading size="lg" class="mt-6">Tanggal Revisi</flux:heading>
            <flux:text size="md" class="mt-2">{{ $item->updated_at->format('d-m-y') }}</flux:text>

            <flux:heading size="lg" class="mt-6">Tanggal Dibaca</flux:heading>
            @if ($item->waktu_pesan_dibaca === null)
                <flux:text size="md" class="mt-2">Belum dibaca penerima</flux:text>
            @else
                <flux:text size="md" class="mt-2">
                    {{ \Carbon\Carbon::parse($item->waktu_pesan_dibaca)->diffForHumans() }}</flux:text>
            @endif

            @if ($item->file_path_revisi)
                <flux:heading size="lg" class="mt-6">Dokumen Revisi</flux:heading>
                <flux:button icon="arrow-down-tray" class="mr-2" wire:click="download({{ $item->id }})">
                </flux:button>
            @endif


            <flux:heading size="lg" class="mt-6">Status Dokumen</flux:heading>
            @if ($item->status === 0)
                <span class="bg-red-500 text-white text-s px-2 py-1 rounded-md">
                    Rejected
                </span>
                <flux:heading size="lg" class="mt-6">Pesan Revisi Dokumen</flux:heading>
                <flux:text size="md" class="mt-2">{{ $item->pesan_revisi }}</flux:text>
            @else
                <span class="bg-green-500 text-white text-s px-2 py-1 rounded-md">
                    Approved
                </span>
            @endif


            {{-- <flux:heading size="lg" class="mt-6">Dokumen Revisi</flux:heading>
            <flux:button href="#" variant="primary" color="emerald" class="mt-2" icon="arrow-down-tray">Unduh
                Dokumen Revisi</flux:button> --}}
        </div>
    @endforeach
</div>
