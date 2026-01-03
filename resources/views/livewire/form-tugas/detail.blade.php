<div>
    <flux:heading size="xl">Detail Form Tugas</flux:heading>
    <flux:text class="mt-2">Berikut merupakan detail Form Tugas
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
            <flux:button icon="arrow-down-tray" class="mr-2 mt-2" variant="primary" color="emerald"
                wire:click="download({{ $formtugas->id }})">
                Unduh Lampiran</flux:button>
        @else
            <flux:text size="md" class="mt-2">Tidak ada lampiran file</flux:text>
        @endif

        @if (auth()->user()->id === $formtugas->user_id)
            <flux:heading size="lg" class="mt-6">Status</flux:heading>
            @if ($formtugas->status === '0')
                <div class="bg-red-100 text-red-800 w-fit p-1 rounded">
                    Belum dibaca penerima
                </div>
            @elseif ($formtugas->status === '1')
                <div class="bg-yellow-100 text-yellow-800 w-fit p-1 rounded">
                    Sedang dalam pengerjaan
                </div>
            @elseif ($formtugas->status === '2')
                <div class="bg-green-100 text-green-800 w-fit p-1 rounded">
                    Tugas telah selesai dikerjakan
                </div>
            @endif

            <flux:heading size="lg" class="mt-6">Waktu Dibaca</flux:heading>
            @if ($formtugas->waktu_dibaca === null)
                <flux:text size="md" class="mt-2">Belum dibaca penerima</flux:text>
            @else
                {{-- {{ $formtugas->waktu_dibaca }} --}}
                <flux:text size="md" class="mt-2">
                    {{ \Carbon\Carbon::parse($formtugas->waktu_dibaca)->diffForHumans() }}</flux:text>
            @endif
        @endif



        @if ($formtugas->check_penerima_id === true)
            <flux:heading size="lg" class="mt-6">Perubahan Status</flux:heading>
            @if ($formtugas->status === '2')
                <div class="bg-green-100 text-green-800 w-fit p-1 rounded mt-2">
                    <flux:text size="md">Tugas telah selesai dikerjakan</flux:text>
                </div>
            @else
                <flux:text size="md" class="mt-2">Jika tugas selesai maka klik tombol Berikut</flux:text>
                <flux:modal.trigger name="done-form-tugas">
                    <flux:button variant="primary" class="mt-2" icon="check" color="emerald" wire:loading.attr="disabled">
                        Tugas Selesai
                    </flux:button>
                </flux:modal.trigger>

                <flux:modal name="done-form-tugas" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Tandai Selesai Form Tugas?</flux:heading>
                            <flux:text class="mt-2">
                                Anda akan menandai Form Tugas tersebut sebagai selesai. <br />
                                Apakah Anda yakin?
                            </flux:text>
                        </div>
                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Batal</flux:button>
                            </flux:modal.close>
                            <flux:button type="submit" variant="primary" color="emerald" wire:click="updateStatus({{ $formtugas->id }})">Yakin</flux:button>
                        </div>
                    </div>
                </flux:modal>
            @endif
        @endif

        {{-- <flux:heading size="lg" class="mt-6">Dokumen Revisi</flux:heading>
            <flux:button href="#" variant="primary" color="emerald" class="mt-2" icon="arrow-down-tray">Unduh
                Dokumen Revisi</flux:button> --}}
    </div>


</div>
