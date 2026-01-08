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
        <flux:heading size="xl">Riwayat Proposal Tender</flux:heading>
        <flux:text class="mt-2">Berikut merupakan Riwayat Proposal Tender yang ada pada PT Adi Banuwa</flux:text>
    </div>

    {{-- ===== MANAJER TEKNIK SECTION ==== --}}
    {{-- pengecekan permission, jika memenuhi syarat maka bisa tampil, manajer permissionnya view proposal dan validate saja --}}
    @can('validate proposal')
        {{-- tabel manajer --}}
        <div class="overflow-x-auto rounded-md border border-gray-200">
            <table class="w-full text-sm text-center bg-white">
                <thead class="bg-green-50 text-white">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama Tender</th>
                        {{-- <th class="px-4 py-3 font-medium">Nama Proposal</th> --}}
                        <th class="px-4 py-3 font-medium">File Proposal</th>
                        <th class="px-4 py-3 font-medium">Dibuat Oleh</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium">Validator</th>
                        <th class="px-4 py-3 font-medium">Riwayat Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @if ($proposals->isEmpty())
                        <tr>
                            <td colspan="6" class="px-4 py-6">
                                Tidak ada proposal untuk ditampilkan.
                            </td>
                        </tr>
                    @else
                        @foreach ($proposals as $item)
                            {{-- @dd($item->status_proposal) --}}
                            <tr>
                                {{-- nama tender --}}
                                <td class="px-4 py-3">{{ $item->tender->nama_tender }}</td>
                                {{-- <td class="px-4 py-3">{{ $item->nama_proposal }}</td> --}}

                                {{-- download tender --}}
                                {{-- file proposal diberi logo download dan jika diklik maka auto download --}}
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
                                <td class="px-4 py-3">
                                    {{ $item->validator }}
                                </td>

                                {{-- tipe dokumen --}}
                                <!-- <td class="px-4 py-3">
                                            {{-- logic pengambilan data ada di model proposal --}}
                                            {{-- {{ $item->status_proposal }} --}}
                                        </td> -->

                                {{-- riwayat status --}}
                                <td class="px-4 py-3">
                                    <flux:button icon="information-circle" class="mr-2"
                                        :href="route('proposal.detail', ['id' => $item->id])"
                                        :current="request()->routeIs('proposal.detail', ['id' => $item->id])" wire:navigate
                                        variant="primary" color="yellow">
                                    </flux:button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class=" pl-1 m-2">
                {{ $proposals->links() }}
            </div>
        </div>
    @endcan


    {{-- ===== MANAJER ADM SECTION ==== --}}
    {{-- pengecekan permission, jika memenuhi syarat maka bisa tampil, manajer permissionnya view proposal dan validate saja --}}
    @can(['view proposal'])
        @cannot(['validate proposal'])
            @cannot(['create proposal'])
                <div class="overflow-x-auto rounded-md border border-gray-200">
                    <table class="w-full text-sm text-center bg-white">
                        <thead class="bg-green-50 text-white">
                            <tr>
                                <th class="px-4 py-3 font-medium">Nama Tender</th>
                                {{-- <th class="px-4 py-3 font-medium">Nama Proposal</th> --}}
                                <th class="px-4 py-3 font-medium">File Proposal</th>
                                <th class="px-4 py-3 font-medium">Keterangan</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @if ($proposals->isEmpty())
                                <tr>
                                    <td colspan="3" class="px-4 py-6">
                                        Tidak ada proposal untuk ditampilkan.
                                    </td>
                                </tr>
                            @else
                                @foreach ($proposals as $item)
                                    <tr>
                                        {{-- nama tender --}}
                                        <td class="px-4 py-3">{{ $item->tender->nama_tender }}</td>
                                        {{-- <td class="px-4 py-3">{{ $item->nama_proposal }}</td> --}}

                                        {{-- file proposal --}}
                                        {{-- file proposal diberi logo download dan jika diklik maka auto download --}}
                                        <td class="px-4 py-3">
                                            <flux:button icon="arrow-down-tray" class="mr-2"
                                                wire:click="download({{ $item->id }})"></flux:button>
                                        </td>

                                        {{-- keterangan --}}
                                        <td class="px-4 py-3">
                                            @if ($item->status === 1 && $item->keterangan !== null)
                                                <span class="bg-green-500 text-white text-s px-2 py-1 rounded-md">
                                                    {{ $item->keterangan ?? 'Proposal belum diperiksa' }} </span>
                                            @elseif($item->status === 0 && $item->keterangan !== null)
                                                <span class="bg-red-500 text-white text-s px-2 py-1 rounded-md">
                                                    {{ $item->keterangan ?? 'Proposal belum diperiksa' }} </span>
                                            @else
                                                <span class=" bg-gray-500 text-white text-s px-2 py-1 rounded-md">
                                                    {{ $item->keterangan ?? 'Proposal belum diperiksa' }} </span>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class=" pl-1 m-2">
                        {{ $proposals->links() }}
                    </div>
                </div>
            @endcannot
        @endcannot
    @endcan


    {{-- ===== STAFF SECTION ==== --}}
    {{-- pengecekan permssion, jika memenuhi syarat maka bisa tampil, staff memiliki permission yang tidak dimilki oleh manajer yakni create proposal. staff ada permission view,create dan validate --}}
    @can('create proposal')
        <div class="overflow-x-auto rounded-md border border-gray-200">
            <table class="w-full text-sm text-center bg-white">
                <thead class="bg-green-50 text-white">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama Tender</th>
                        {{-- <th class="px-4 py-3 font-medium">Nama Proposal</th> --}}
                        <th class="px-4 py-3 font-medium">File Proposal</th>
                        <th class="px-4 py-3 font-medium">Dibuat Oleh</th>
                        <th class="px-4 py-3 font-medium">Status Proposal</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @if ($proposals->isEmpty())
                        <tr>
                            <td colspan="4" class="px-4 py-6">
                                Tidak ada proposal untuk ditampilkan.
                            </td>
                        </tr>
                    @else
                        @foreach ($proposals as $item)
                            <tr>
                                {{-- nama tender --}}
                                <td class="px-4 py-3">{{ $item->tender->nama_tender }}</td>
                                {{-- <td class="px-4 py-3">{{ $item->nama_proposal }}</td> --}}

                                {{-- file proposal --}}
                                {{-- file proposal diberi logo download dan jika diklik maka auto download --}}
                                <td class="px-4 py-3">
                                    <flux:button icon="arrow-down-tray" class="mr-2"
                                        wire:click="download({{ $item->id }})"></flux:button>
                                </td>

                                {{-- dibuat oleh --}}
                                <td class="px-4 py-3">
                                    {{ $item->user->name }}
                                </td>

                                {{-- status proposal --}}
                                @if ($item->status === 1)
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
                {{ $proposals->links() }}
            </div>
        </div>
    @endcan




</div>
