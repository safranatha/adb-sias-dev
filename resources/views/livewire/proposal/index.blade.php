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

    {{-- ===== MANAJER TEKNIK SECTION ==== --}}
    {{-- pengecekan permission, jika memenuhi syarat maka bisa tampil, manajer permissionnya view proposal dan validate saja --}}
    @can('validate proposal')
        {{-- tabel manajer --}}
        <div class="mb-5">
            <flux:heading size="xl">Daftar Proposal Tender</flux:heading>
            <flux:text class="mt-2">Berikut merupakan daftar Proposal Tender yang ada pada PT Adi Banuwa</flux:text>
        </div>


        <div class="overflow-x-auto rounded-md border border-gray-200">
            <table class="w-full text-sm text-center">
                <thead class="bg-green-50 text-white">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama Tender</th>
                        {{-- <th class="px-4 py-3 font-medium">Nama Proposal</th> --}}
                        <th class="px-4 py-3 font-medium">File Proposal</th>
                        <th class="px-4 py-3 font-medium">Dibuat Oleh</th>
                        <th class="px-4 py-3 font-medium">Validate</th>
                        <th class="px-4 py-3 font-medium">Validator</th>
                        <th class="px-4 py-3 font-medium">Riwayat Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @if ($document_approvals->isEmpty())
                        <tr>
                            <td colspan="3" class="px-4 py-6">
                                Tidak ada proposal untuk ditampilkan.
                            </td>
                        </tr>
                    @else
                        @foreach ($document_approvals as $item)
                            {{-- @dd($item->status_proposal) --}}
                            <tr>
                                {{-- nama tender --}}
                                <td class="px-4 py-3">{{ $item->proposal->tender->nama_tender }}</td>
                                {{-- <td class="px-4 py-3">{{ $item->nama_proposal }}</td> --}}

                                {{-- download tender --}}
                                {{-- file proposal diberi logo download dan jika diklik maka auto download --}}
                                <td class="px-4 py-3">
                                    <flux:button icon="arrow-down-tray" class="mr-2"
                                        wire:click="download({{ $item->proposal->id }})"></flux:button>
                                </td>

                                {{-- dibuat oleh --}}
                                <td class="px-4 py-3">
                                    {{ $item->proposal->user->name }}
                                </td>


                                {{-- validasi propo --}}
                                {{-- cek apakah sudah di validasi --}}
                                @if ($item->status !== null)
                                    <td class="px-4 py-3">
                                        <span class="bg-green-500 text-white text-s px-2 py-1 rounded-md">
                                            Sudah diperiksa
                                        </span>
                                    </td>
                                @else
                                    <td class="px-4 py-3">
                                        {{-- validate proposal --}}
                                        {{-- button approve --}}
                                        <flux:button icon="check" class="mr-2"
                                            wire:click="approve({{ $item->proposal->id }})" variant="primary"
                                            color="green">
                                        </flux:button>

                                        {{-- button reject --}}
                                        <flux:modal.trigger name="reject-proposal-{{ $item->proposal->id }}">
                                            <flux:button icon="x-mark" variant="danger"></flux:button>
                                        </flux:modal.trigger>

                                        {{-- modal form reject --}}
                                        <flux:modal name="reject-proposal-{{ $item->proposal->id }}">
                                            <form wire:submit.prevent="reject({{ $item->proposal->id }})">
                                                <flux:field>
                                                    <flux:label class="mt-3">Alasan Penolakan</flux:label>
                                                    <flux:textarea wire:model="pesan_revisi"></flux:textarea>
                                                    @error('pesan_revisi')
                                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                                    @enderror
                                                </flux:field>
                                                <flux:button type="submit" class="mt-6" variant="danger">
                                                    Tolak
                                                </flux:button>
                                            </form>
                                        </flux:modal>
                                    </td>
                                @endif

                                {{-- validator --}}
                                <td class="px-4 py-3">
                                    {{ $item->user->name }}
                                </td>

                                {{-- tipe dokumen --}}
                                <!-- <td class="px-4 py-3">
                                    {{-- logic pengambilan data ada di model proposal --}}
                                    {{ $item->status_proposal }}
                                </td> -->
                                
                                {{-- riwayat status --}}
                                <td class="px-4 py-3">
                                    <flux:button icon="information-circle" class="mr-2"
                                            :href="route('proposal.detail', ['id' => $item->proposal->id])"
                                            :current="request()->routeIs('proposal.detail', ['id' => $item->proposal->id])" wire:navigate variant="primary"
                                            color="yellow">
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
                {{-- tabel manajer admin --}}
                <div class="mb-5">
                    <flux:heading size="xl">Daftar Proposal Tender</flux:heading>
                    <flux:text class="mt-2">Berikut merupakan daftar Proposal Tender yang ada pada PT Adi Banuwa</flux:text>
                </div>
                
                <div class="overflow-x-auto rounded-md border border-gray-200">
                    <table class="w-full text-sm text-center">
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
        {{-- tabel staff --}}
        <div class="mb-5">
            <flux:heading size="xl">Daftar Proposal Tender</flux:heading>
            <flux:text class="mt-2">Berikut merupakan daftar Proposal Tender yang ada pada PT Adi Banuwa</flux:text>
        </div>
                
        <div class="overflow-x-auto rounded-md border border-gray-200">
            <table class="w-full text-sm text-center">
                <thead class="bg-green-50 text-white">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama Tender</th>
                        {{-- <th class="px-4 py-3 font-medium">Nama Proposal</th> --}}
                        <th class="px-4 py-3 font-medium">File Proposal</th>
                        <th class="px-4 py-3 font-medium">Dibuat Oleh</th>
                        <th class="px-4 py-3 font-medium">Pesan</th>

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

                                {{-- dibuat oleh --}}
                                <td class="px-4 py-3">
                                    {{ $item->user->name }}
                                </td>

                                {{-- edit dan pesan --}}

                                <td>
                                    @if ($item->status === 1 && $item->keterangan !== null)
                                        {{-- kondisi acc validasi --}}
                                        <flux:button icon="envelope" class="mr-2" variant="primary" color="green">
                                            {{ $item->keterangan }}
                                        </flux:button>
                                    @elseif($item->status === null)
                                        {{-- kondisi belum di validasi --}}
                                        <flux:button icon="envelope" class="mr-2" variant="primary">
                                            {{ $item->keterangan ?? 'Proposal belum diperiksa' }}
                                        </flux:button>
                                    @else
                                        {{-- kondisi jika ada revisi --}}
                                        <flux:modal.trigger name="edit-proposal-{{ $item->id }}">
                                            <flux:button icon="envelope" class="mr-2"
                                                wire:click="edit({{ $item->id }})" variant="primary" color="red">
                                                {{ $item->keterangan }}
                                            </flux:button>
                                        </flux:modal.trigger>

                                        {{-- modal form --}}
                                        <flux:modal name="edit-proposal-{{ $item->id }}">
                                            <flux:field>
                                                <flux:label class="mt-3">Pesan Revisi</flux:label>
                                                <flux:text class=" text-left">{{ $item->pesan_revisi }}</flux:text>
                                            </flux:field>
                                            <form wire:submit.prevent="update">
                                                <flux:field>
                                                    <flux:label class="mt-3">Nama Proposal</flux:label>
                                                    <flux:text class=" text-left">{{ $item->nama_proposal }}</flux:text>

                                                    {{-- <flux:input wire:model="nama_proposal" />
                                                    @error('nama_proposal')
                                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                                    @enderror --}}
                                                </flux:field>

                                                <flux:field>
                                                    {{-- <flux:label class="mt-3">File Proposal</flux:label> --}}

                                                    @if ($file_path_proposal)
                                                        <p class="text-sm mt-3">
                                                            File saat ini: {{ basename($file_path_proposal) }}
                                                        </p>
                                                    @endif
                                                    <flux:input type="file" wire:model="file_path_proposal" />
                                                    @error('file_path_proposal')
                                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                                    @enderror
                                                </flux:field>

                                                <flux:button type="submit" class="mt-6" variant="primary">
                                                    Update
                                                </flux:button>
                                            </form>
                                        </flux:modal>
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
    @endcan




</div>
