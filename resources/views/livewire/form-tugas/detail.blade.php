<div>
    <flux:heading size="xl">Detail Form TUgas</flux:heading>
    <flux:text class="mt-2">Berikut merupakan detail Form TUgas
        {{ $formtugas->kegiatan }}.
    </flux:text>


    <div class="color-white bg-white p-10 rounded-lg shadow-md mt-6">
        <flux:heading size="lg">Jenis Permintaan</flux:heading>
        <flux:text size="md" class="mt-2">{{ $formtugas->jenis_permintaan }}</flux:text>

        <flux:heading size="lg" class="mt-6">Kegiatan</flux:heading>
        <flux:text size="md" class="mt-2">{{ $formtugas->kegiatan }}</flux:text>

        <flux:heading size="lg" class="mt-6">Lingkup Kerja</flux:heading>
        <flux:text size="md" class="mt-2">{{ $formtugas->lingkup_kerja }}</flux:text>

        <flux:heading size="lg" class="mt-6">Keterangan</flux:heading>
        <flux:text size="md" class="mt-2">{{ $formtugas->keterangan }}</flux:text>

        <flux:heading size="lg" class="mt-6">File</flux:heading>
        @if ($formtugas->file_path_form_tugas !== null)
            <flux:button icon="arrow-down-tray" class="mr-2" wire:click="download({{ $formtugas->id }})">
            </flux:button>
        @else
            <flux:text size="md" class="mt-2">Tidak ada attachment file</flux:text>
        @endif

        <flux:heading size="lg" class="mt-6">Statu</flux:heading>
        @if ($formtugas->status === '0')
            <flux:text size="md" class="mt-2">Belum dibaca penerima</flux:text>
        @elseif ($formtugas->status === '1')
            <flux:text size="md" class="mt-2">Sedang dalam pengerjaan</flux:text>
        @elseif($formtugas->status === '2')
            <flux:text size="md" class="mt-2">Tugas telah selesai dikerjakan</flux:text>
        @endif


        <flux:heading size="lg" class="mt-6">Waktu Dibaca</flux:heading>
        @if ($formtugas->waktu_dibaca === null)
            <flux:text size="md" class="mt-2">Belum dibaca penerima</flux:text>
        @else
            {{-- {{ $formtugas->waktu_dibaca }} --}}
            <flux:text size="md" class="mt-2">
                {{ \Carbon\Carbon::parse($formtugas->waktu_dibaca)->diffForHumans() }}</flux:text>
        @endif

        @if ($formtugas->check_penerima_id === true)
            <flux:heading size="lg" class="mt-6">Perubahan Status</flux:heading>
            <flux:text size="md" class="mt-2">Jika sudah selesai maka klik tombol Berikut</flux:text>
            <flux:button type="submit" variant="primary" color="emerald" wire:loading.attr="disabled"
                wire:click="updateStatus({{ $formtugas->id }})">
                Tugas telah selesai
            </flux:button>
        @endif

        {{-- <flux:heading size="lg" class="mt-6">Dokumen Revisi</flux:heading>
            <flux:button href="#" variant="primary" color="emerald" class="mt-2" icon="arrow-down-tray">Unduh
                Dokumen Revisi</flux:button> --}}
    </div>


</div>
