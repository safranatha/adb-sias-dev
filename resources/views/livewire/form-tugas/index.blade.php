{{-- VIEW HISTORY PEMBERIAN PERINTAH FORM TUGAS --}}
<div>
    @if (auth()->user()->hasRole(['Direktur', 'Asisten Direktur']))
        <div class="max-w-6xl mx-auto">

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
                <flux:heading size="xl">Daftar Form Tugas</flux:heading>
                <flux:text class="mt-2">Berikut merupakan History Form Tugas yang telah diberikan kepada Manager
                </flux:text>
            </div>

            <div class="overflow-x-auto rounded-md border border-gray-200">
                <table class="w-full text-sm text-center">
                    <thead class="bg-green-50 text-white">
                        <tr>
                            {{-- <th class="px-4 py-3 font-medium">Pembuat</th> --}}
                            <th class="px-4 py-3 font-medium">Jenis Permintaan</th>
                            <th class="px-4 py-3 font-medium">Kegiatan</th>
                            <th class="px-4 py-3 font-medium">Keterangan</th>
                            <th class="px-4 py-3 font-medium">Lingkup Kerja</th>
                            <th class="px-4 py-3 font-medium">Due Date</th>
                            <th class="px-4 py-3 font-medium">File</th>
                            <th class="px-4 py-3 font-medium">Penerima</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @if ($formtugas->isEmpty())
                            <tr>
                                <td colspan="2" class="px-4 py-6">
                                    Tidak ada Form tugas untuk ditampilkan.
                                </td>
                            </tr>
                        @else
                            @foreach ($formtugas as $item)
                                <tr>
                                    <td class="px-4 py-3">{{ $item->jenis_permintaan }}</td>
                                    <td class="px-4 py-3">{{ $item->kegiatan }}</td>
                                    <td class="px-4 py-3"> {{ $item->keterangan }}</td>
                                    <td class="px-4 py-3"> {{ $item->lingkup_kerja }}</td>
                                    <td class="px-4 py-3"> {{ $item->due_date }}</td>
                                    <td class="px-4 py-3">
                                        @if ($item->file_path_form_tugas !== null)
                                            <flux:button icon="arrow-down-tray" class="mr-2"
                                                wire:click="download({{ $item->id }})"></flux:button>
                                        @else
                                            Tidak ada attachment file
                                        @endif

                                    </td>
                                    <td class="px-4 py-3"> {{ $item->penerima }}</td>
                                    <td class="px-4 py-3">
                                        @if ($item->status === 0)
                                            Belum dibaca penerima
                                        @else
                                            Sudah dibaca penerima
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @elseif (auth()->user()->hasRole(['Manajer Teknik', 'Manajer Admin']))
        <p>Ini tabel untuk para manajer</p>
    @endif
</div>
