{{-- FORM TUGAS AKTIF --}}
<div>
    <div class="max-w-8xl mx-auto">
        {{-- success message after internal memo created --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-3 successMsg">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    document.getElementsByClassName('successMsg')?.remove();
                }, 200);
            </script>
        @endif

        <div class="mb-5">
            <flux:heading size="xl">Tugas Anda</flux:heading>
            <flux:text class="mt-2">Berikut merupakan Form Tugas yang telah diberikan kepada Anda
            </flux:text>
        </div>

        <div class="overflow-x-auto rounded-md border border-gray-200">
            <table class="w-full text-sm text-center">
                <thead class="bg-green-50 text-white">
                    <tr>
                        {{-- <th class="px-4 py-3 font-medium">Pembuat</th> --}}
                        <th class="px-4 py-3 font-medium">Ditugaskan Oleh</th>
                        <th class="px-4 py-3 font-medium">Jenis Permintaan</th>
                        <th class="px-4 py-3 font-medium">Kegiatan</th>
                        {{-- <th class="px-4 py-3 font-medium">Keterangan</th> --}}
                        {{-- <th class="px-4 py-3 font-medium">Lingkup Kerja</th> --}}
                        <th class="px-4 py-3 font-medium">Tenggat Waktu</th>
                        {{-- <th class="px-4 py-3 font-medium">File</th> --}}
                        <th class="px-4 py-3 font-medium">Penerima</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        {{-- <th class="px-4 py-3 font-medium">Waktu Dibaca</th> --}}
                        <th class="px-4 py-3 font-medium">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @if ($formtugas_penerima->isEmpty())
                        <tr>
                            <td colspan="5" class="px-4 py-6">
                                Tidak ada Form tugas untuk ditampilkan.
                            </td>
                        </tr>
                    @else
                        @foreach ($formtugas_penerima as $item)
                            <tr>
                                <td class="px-4 py-3"> {{ $item->user->name }}</td>
                                <td class="px-4 py-3">{{ $item->jenis_permintaan }}</td>
                                <td class="px-4 py-3">{{ $item->kegiatan }}</td>
                                {{-- <td class="px-4 py-3"> {{ $item->keterangan }}</td> --}}
                                {{-- <td class="px-4 py-3"> {{ $item->lingkup_kerja }}</td> --}}
                                <td class="px-4 py-3"> {{ $item->due_date }}</td>
                                {{-- <td class="px-4 py-3">
                                        @if ($item->file_path_form_tugas !== null)
                                            <flux:button icon="arrow-down-tray" class="mr-2"
                                                wire:click="download({{ $item->id }})"></flux:button>
                                        @else
                                            Tidak ada attachment file
                                        @endif

                                    </td> --}}
                                <td class="px-4 py-3"> {{ $item->penerima }}</td>
                                <td class="px-4 py-3">
                                    @if ($item->status === '0')
                                        <div class="mx-auto bg-red-500 text-white text-s px-2 py-1 rounded-md w-fit">
                                            Belum Anda Baca
                                        </div>
                                    @elseif ($item->status === '1')
                                        <div class="mx-auto bg-yellow-500 text-black text-s px-2 py-1 rounded-md w-fit">
                                            Sudah Anda Baca | Dikerjakan
                                        </div>
                                    @elseif($item->status === '2')
                                        <div class="mx-auto bg-green-500 text-white text-s px-2 py-1 rounded-md w-fit">
                                            Tugas Telah Anda Kerjakan
                                        </div>
                                    @endif
                                </td>
                                {{-- <td class="px-4 py-3">
                                    @if ($item->waktu_dibaca === null)
                                        Belum dibaca penerima
                                    @else
                                        {{ \Carbon\Carbon::parse($item->waktu_dibaca)->diffForHumans() }}
                                    @endif
                                </td> --}}
                                <td class="px-4 py-3">
                                    <flux:button icon="information-circle" class="mr-2"
                                        :href="route('form-tugas.detail', ['id' => $item->id])"
                                        :current="request()->routeIs('form-tugas.detail', ['id' => $item->id])"
                                        wire:navigate variant="primary" color="yellow">
                                    </flux:button>
                                </td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
