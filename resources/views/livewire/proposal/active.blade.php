<div>
    {{-- Success/Error Messages --}}
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

    {{-- Header Section --}}
    <div class="mb-5">
        <flux:heading size="xl">Proposal Aktif</flux:heading>
        <flux:text class="mt-2">Berikut merupakan daftar Proposal Tender yang belum disetujui oleh Manajer Teknik
        </flux:text>
    </div>


    {{-- ===== MANAJER TEKNIK SECTION ==== --}}
    {{-- pengecekan permission, jika memenuhi syarat maka bisa tampil, manajer permissionnya view proposal dan validate saja --}}
    @can('validate proposal')
        <div class="overflow-x-auto rounded-md border border-gray-200">
            <table class="w-full text-sm text-center">
                <thead class="bg-green-700 text-white">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama Tender</th>
                        <th class="px-4 py-3 font-medium">File Proposal</th>
                        <th class="px-4 py-3 font-medium">Dibuat Oleh</th>
                        <th class="px-4 py-3 font-medium">Validate</th>
                        <th class="px-4 py-3 font-medium">Status Proposal</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">
                    @if ($document_approvals->isEmpty())
                        <tr>
                            <td colspan="5" class="px-4 py-6">
                                Tidak ada Proposal status aktif.
                            </td>
                        </tr>
                    @else
                        @foreach ($document_approvals as $item)
                            <tr>
                                {{-- nama tender --}}
                                <td class="px-4 py-3">{{ $item->proposal->tender->nama_tender }}</td>

                                {{-- download file --}}
                                <td class="px-4 py-3">
                                    <flux:button icon="arrow-down-tray" class="mr-2"
                                        wire:click="download({{ $item->proposal->id }})"></flux:button>
                                </td>

                                {{-- dibuat oleh --}}
                                <td class="px-4 py-3">{{ $item->proposal->user->name }}</td>

                                {{-- validate --}}
                                <td class="px-4 py-3">
                                    {{-- validate sph --}} {{-- button approve --}}
                                    <flux:modal.trigger name="approve-proposal">
                                        <flux:button icon="check" class="mr-2" variant="primary" color="green">
                                        </flux:button>
                                    </flux:modal.trigger>

                                    <flux:modal name="approve-proposal" class="min-w-[22rem] text-left">
                                        <div class="space-y-6">
                                            <div>
                                                <flux:heading size="lg">Setujui proposal?</flux:heading>
                                                <flux:text class="mt-2">
                                                    Anda akan menyetujui proposal tersebut.<br>
                                                    Proposal yang sudah disetujui akan dilanjutkan ke Direktur.
                                                </flux:text>
                                            </div>
                                            <div class="flex gap-2">
                                                <flux:spacer />
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Batal</flux:button>
                                                </flux:modal.close>
                                                <flux:button wire:click="approve({{ $item->proposal->id }})"
                                                    variant="primary" color="emerald">Yakin</flux:button>
                                            </div>
                                        </div>
                                    </flux:modal>

                                    {{-- button reject --}}
                                    <flux:modal.trigger name="reject-sph-{{ $item->proposal->id }}">
                                        <flux:button icon="x-mark" variant="danger"></flux:button>
                                    </flux:modal.trigger>

                                    {{-- modal form reject --}}
                                    <flux:modal name="reject-sph-{{ $item->proposal->id }}">
                                        <form wire:submit.prevent="reject({{ $item->proposal->id }})">
                                            <flux:field>
                                                <flux:label class="mt-3">Alasan Penolakan</flux:label>
                                                <flux:input type="file" wire:model="file_path_revisi" />
                                                {{-- Loading indicator saat upload --}}
                                                <div wire:loading wire:target="file_path_revisi"
                                                    class="text-sm text-gray-500 mt-1">
                                                    Uploading file...
                                                </div>
                                                @error('file_path_revisi')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                                <flux:textarea wire:model="pesan_revisi"></flux:textarea>
                                                @error('pesan_revisi')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                            </flux:field>
                                            <flux:modal.trigger name="reject-proposal">
                                                <flux:button class="mt-6" variant="danger">
                                                    Tolak
                                                </flux:button>
                                            </flux:modal.trigger>
                                            <flux:modal name="reject-proposal" class="min-w-[22rem] text-left">
                                                <div class="space-y-6">
                                                    <div>
                                                        <flux:heading size="lg">Tolak proposal?</flux:heading>
                                                        <flux:text class="mt-2">
                                                            Anda akan menolak proposal tersebut.<br>
                                                            Proposal yang ditolak akan dikembalikan lagi ke Staff.
                                                        </flux:text>
                                                    </div>
                                                    <div class="flex gap-2">
                                                        <flux:spacer />
                                                        <flux:modal.close>
                                                            <flux:button variant="ghost">Batal</flux:button>
                                                        </flux:modal.close>
                                                        <flux:button type="submit" variant="danger">Tolak</flux:button>
                                                    </div>
                                                </div>
                                            </flux:modal>
                                        </form>
                                    </flux:modal>
                                </td>

                                {{-- <td class="px-4 py-3">
                                <div class="flex gap-2 justify-center">
                                    <flux:button icon="check" size="sm" variant="primary" color="green">
                                    </flux:button>
                                    <flux:button icon="x-mark" size="sm" variant="danger"></flux:button>
                                </div>
                            </td> --}}

                                <td class="px-4 py-3">
                                    <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-md">
                                        {{ $item->status_proposal }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{-- Static Pagination Info --}}
            <div class="pl-1 m-2">
                {{ $document_approvals->links() }}
            </div>
        </div>
    @endcan

    {{--  ===== STAFF SECTION ====  --}}
    {{-- tabel staff --}}
    @can('create proposal')
        <div class="overflow-x-auto rounded-md border border-gray-200 ">
            <table class="w-full text-sm text-center">
                <thead class="bg-green-700 text-white">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama Tender</th>
                        <th class="px-4 py-3 font-medium">File Proposal</th>
                        <th class="px-4 py-3 font-medium">Dibuat Oleh</th>
                        <th class="px-4 py-3 font-medium">Pesan</th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">
                    @if ($proposals_active->isEmpty())
                        <tr>
                            <td colspan="3" class="px-4 py-6">
                                Tidak ada proposal status aktif.
                            </td>
                        </tr>
                    @endif
                    @foreach ($proposals_active as $item)
                        {{-- yang tampil adalah yang statusnya revisi/belum disetujui --}}
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
                                @if ($item->status === 0 && $item->keterangan !== null)
                                    {{-- kondisi jika ada revisi --}}
                                    <flux:modal.trigger name="edit-proposal-{{ $item->id }}">
                                        @if ($item->latestWorkflow?->waktu_pesan_dibaca === null)
                                            {{-- BELUM DIBACA --}}
                                            <flux:button icon="envelope" class="mr-2"
                                                wire:click="edit({{ $item->id }})" variant="primary" color="red">
                                                {{ $item->keterangan }}
                                            </flux:button>
                                        @else
                                            {{-- SUDAH DIBACA --}}
                                            <flux:button icon="envelope-open" class="mr-2"
                                                wire:click="edit({{ $item->id }})" variant="filled">
                                                {{ $item->keterangan }}
                                            </flux:button>
                                        @endif
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
                                                <flux:text class=" text-left">{{ $item->nama_proposal }}
                                                </flux:text>

                                                {{-- <flux:input wire:model="nama_proposal" />
                                                @error('nama_proposal')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror --}}
                                            </flux:field>

                                            <flux:field>
                                                <flux:label class="mt-3">Doc Rev</flux:label>
                                                <flux:button icon="arrow-down-tray" class="mr-2"
                                                    wire:click="downloadFileRevisi({{ $item->id }})">
                                                </flux:button>
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
                                @else
                                    {{-- kondisi belum di validasi --}}
                                    <flux:button icon="envelope" class="mr-2" variant="primary">
                                        {{ $item->keterangan ?? 'Proposal belum diperiksa' }}
                                    </flux:button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    {{-- @endif --}}
                </tbody>
            </table>
            <div class=" pl-1 m-2">
                {{ $proposals_active->links() }}
            </div>
        </div>
    @endcan



</div>
