<div>

    {{-- success message after post created --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
            x-transition:leave="transition ease-out duration-500" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="bg-green-100 text-green-800 px-4 py-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
            x-transition:leave="transition ease-out duration-500" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="bg-red-100 text-red-800 px-4 py-2 rounded mb-3">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-5">
        <flux:heading size="xl">Riwayat Surat Penawaran Harga</flux:heading>
        <flux:text class="mt-2">Berikut merupakan seluruh riwayat Surat Penawaran Harga Tender yang ada pada PT Adi
            Banuwa</flux:text>
    </div>

    {{-- ===== MANAJER ADMIN SECTION ==== --}}
    @can('validate surat penawaran harga')

        <div class="overflow-x-auto rounded-md border border-gray-200">
            <table class="w-full text-sm text-center">
                <thead class="bg-green-50 text-white">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama Tender</th>
                        {{-- <th class="px-4 py-3 font-medium">Nama Surat Penawaran Harga</th> --}}
                        <th class="px-4 py-3 font-medium">File Surat Penawaran Harga</th>
                        <th class="px-4 py-3 font-medium">Dibuat Oleh</th>
                        <th class="px-4 py-3 font-medium">Validate</th>
                        <!-- <th class="px-4 py-3 font-medium">Validator</th> -->
                        <th class="px-4 py-3 font-medium">Riwayat Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @if ($sphs->isEmpty())
                        <tr>
                            <td colspan="3" class="px-4 py-6">
                                Tidak ada Surat Penawaran Harga untuk ditampilkan.
                            </td>
                        </tr>
                    @else
                        @foreach ($sphs as $item)
                            <tr>
                                {{-- nama tender --}}
                                <td class="px-4 py-3">{{ $item->tender->nama_tender }}</td>
                                {{-- <td class="px-4 py-3">{{ $item->nama_sph }}</td> --}}

                                {{-- download file --}}
                                {{-- file sph diberi logo download dan jika diklik maka auto download --}}
                                <td class="px-4 py-3">
                                    <flux:button icon="arrow-down-tray" class="mr-2"
                                        wire:click="download({{ $item->id }})"></flux:button>
                                </td>

                                {{-- dibuat oleh --}}
                                <td class="px-4 py-3">
                                    {{ $item->user->name }}
                                </td>

                                {{-- validasi propo --}}
                                {{-- cek apakah sudah di validasi --}}
                                @if ($item->status == 1)
                                    <td class="px-4 py-3">
                                        <span class="bg-green-500 text-white text-s px-2 py-1 rounded-md">
                                            Approved
                                        </span>
                                    </td>
                                @else
                                    <td class="px-4 py-3">
                                        <span class="bg-red-500 text-white text-s px-2 py-1 rounded-md">
                                            Rejected
                                        </span>
                                    </td>
                                @endif


                                {{-- validator --}}
                                <!-- <td class="px-4 py-3">
                                    {{ $item->user->name }}
                                </td> -->

                                <!-- {{-- status Surat Penawaran Harga --}}
                                <td class="px-4 py-3">
                                    {{-- logic pengambilan data ada di model proposal --}}
                                    {{ $item->status_sph }}
                                </td> -->
                                
                                {{-- riwayat status --}}
                                <td class="px-4 py-3">
                                    <flux:button icon="information-circle" class="mr-2"
                                            :href="route('surat-penawaran-harga.detail', ['id' => $item->id])"
                                            :current="request()->routeIs('surat-penawaran-harga.detail', ['id' => $item->id])" wire:navigate variant="primary"
                                            color="yellow">
                                        </flux:button>
                                    </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class=" pl-1 m-2">
                {{ $sphs->links() }}
            </div>
        </div>
    @endcan

    {{-- ===== STAFF ADMIN SECTION ==== --}}
    @can('create surat penawaran harga')
        <div class="overflow-x-auto rounded-md border border-gray-200">
            <table class="w-full text-sm text-center">
                <thead class="bg-green-50 text-white">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama Tender</th>
                        {{-- <th class="px-4 py-3 font-medium">Nama Surat Penawaran Harga</th> --}}
                        <th class="px-4 py-3 font-medium">File Surat Penawaran Harga</th>
                        <th class="px-4 py-3 font-medium">Dibuat Oleh</th>
                        <th class="px-4 py-3 font-medium">Status Surat Penawaran Harga</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @if ($sphs->isEmpty())
                        <tr>
                            <td colspan="3" class="px-4 py-6">
                                Tidak ada Surat Penawaran Harga untuk ditampilkan.
                            </td>
                        </tr>
                    @else
                        @foreach ($sphs as $item)
                            <tr>
                                <td class="px-4 py-3">{{ $item->tender->nama_tender }}</td>
                                {{-- <td class="px-4 py-3">{{ $item->nama_sph }}</td> --}}
                                {{-- file sph diberi logo download dan jika diklik maka auto download --}}
                                <td class="px-4 py-3">
                                    <flux:button icon="arrow-down-tray" class="mr-2"
                                        wire:click="download({{ $item->id }})"></flux:button>
                                </td>
                                <td class="px-4 py-3">
                                    {{ $item->user->name }}
                                </td>

                                @if ($item->status == 1)
                                    <td class="px-4 py-3">
                                        <span class="bg-green-500 text-white text-s px-2 py-1 rounded-md">
                                            Approved
                                        </span>
                                    </td>
                                @elseif ($item->status === 0)
                                    <td class="px-4 py-3">
                                        <span class="bg-red-500 text-white text-s px-2 py-1 rounded-md">
                                            Rejected
                                        </span>
                                    </td>
                                @else
                                    <td class="px-4 py-3">
                                        <span class="bg-black text-white text-s px-2 py-1 rounded-md">
                                            Belum Diperiksa
                                        </span>
                                    </td>
                                @endif

                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class=" pl-1 m-2">
                {{ $sphs->links() }}
            </div>
        </div>
    @endcan
</div>
