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
        <flux:heading size="xl">Surat Penawaran Harga Aktif</flux:heading>
        <flux:text class="mt-2">Berikut merupakan daftar Surat Penawaran Harga Tender yang belum disetujui oleh
            Manajer Admin
        </flux:text>
    </div>


    {{-- ===== MANAJER ADMIN SECTION ==== --}}
    {{-- pengecekan permission, jika memenuhi syarat maka bisa tampil, manajer permissionnya view proposal dan validate saja --}}
    @can('validate surat penawaran harga')
        <div class="overflow-x-auto rounded-md border border-gray-200">
            <table class="w-full text-sm text-center">
                <thead class="bg-green-50 text-white">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama SPH</th>
                        <th class="px-4 py-3 font-medium">File SPH</th>
                        <th class="px-4 py-3 font-medium">Dibuat Oleh</th>
                        <th class="px-4 py-3 font-medium">Validate</th>
                        <th class="px-4 py-3 font-medium">Status SPH</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">
                    @if ($document_approvals->isEmpty())
                        <tr>
                            <td colspan="6" class="px-4 py-6">
                                Tidak ada Surat Penawaran Harga aktif.
                            </td>
                        </tr>
                    @else
                        @foreach ($document_approvals as $item)
                            <tr>
                                {{-- nama tender --}}
                                <td class="px-4 py-3">{{ $item->surat_penawaran_harga->tender->nama_tender }}</td>
                                {{-- <td class="px-4 py-3">{{ $item->nama_sph }}</td> --}}

                                {{-- download file --}}
                                {{-- file sph diberi logo download dan jika diklik maka auto download --}}
                                <td class="px-4 py-3">
                                    <flux:button icon="arrow-down-tray" class="mr-2"
                                        wire:click="download({{ $item->surat_penawaran_harga->id }})"></flux:button>
                                </td>

                                {{-- dibuat oleh --}}
                                <td class="px-4 py-3">
                                    {{ $item->surat_penawaran_harga->user->name }}
                                </td>

                                {{-- validasi propo --}}
                                {{-- cek apakah sudah di validasi --}}
                                <td class="px-4 py-3">
                                    {{-- validate sph --}} {{-- button approve --}}
                                    <flux:modal.trigger name="approve-sph-{{ $item->surat_penawaran_harga->id }}">
                                        <flux:button icon="check" class="mr-2" variant="primary" color="green">
                                        </flux:button>
                                    </flux:modal.trigger>

                                    <flux:modal name="approve-sph-{{ $item->surat_penawaran_harga->id }}"
                                        class="min-w-[22rem] text-left">
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

                                                <flux:button wire:click="approve({{ $item->surat_penawaran_harga->id }})"
                                                    variant="primary" color="emerald">
                                                    Yakin
                                                </flux:button>
                                            </div>
                                        </div>
                                    </flux:modal>

                                    {{-- button reject --}}
                                    <flux:modal.trigger name="reject-sph-{{ $item->surat_penawaran_harga->id }}">
                                        <flux:button icon="x-mark" variant="danger"></flux:button>
                                    </flux:modal.trigger>

                                    {{-- modal form reject --}}
                                    <flux:modal name="reject-sph-{{ $item->surat_penawaran_harga->id }}">
                                        <form wire:submit.prevent="reject({{ $item->surat_penawaran_harga->id }})">
                                            <flux:field>
                                                <flux:label class="mt-3">Alasan Penolakan</flux:label>
                                                <flux:input type="file" wire:model="file_path_revisi" />
                                                <div wire:loading wire:target="file_path_revisi"
                                                    class="text-sm text-gray-500 mt-1">
                                                    Uploading file...
                                                </div>
                                                <flux:textarea wire:model="pesan_revisi"></flux:textarea>
                                                @error('pesan_revisi')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                            </flux:field>
                                            <flux:modal.trigger name="reject-sph" wire:loading.attr="disabled"
                                                wire:target="file_path_revisi">
                                                <flux:button class="mt-6" variant="danger">Tolak</flux:button>
                                            </flux:modal.trigger>
                                            <flux:modal name="reject-sph" class="min-w-[22rem] text-left">
                                                <div class="space-y-6">
                                                    <div>
                                                        <flux:heading size="lg">Tolak proposal?</flux:heading>
                                                        <flux:text class="mt-2">
                                                            Anda akan menolak SPH tersebut.<br>
                                                            SPH yang ditolak akan dikembalikan lagi ke Staff.
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
                                {{-- status Surat Penawaran Harga --}}
                                <td class="px-4 py-3">
                                    {{-- logic pengambilan data ada di model sph --}}
                                    <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-md">
                                        {{ $item->status_sph }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @endif
            </table>
        </div>
    @endcan


    {{-- ===== STAFF ADMIN SECTION ==== --}}
    @can('create surat penawaran harga')
        <div class="overflow-x-auto rounded-md border border-gray-200 ">
            <table class="w-full text-sm text-center">
                <thead class="bg-green-50 text-white">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama Tender</th>
                        <th class="px-4 py-3 font-medium">File Surat Penawaran Harga</th>
                        <th class="px-4 py-3 font-medium">Dibuat Oleh</th>
                        <th class="px-4 py-3 font-medium">Pesan</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">
                    @if ($sphs->isEmpty())
                        <tr>
                            <td colspan="6" class="px-4 py-6">
                                Tidak ada Surat Penawaran Harga aktif.
                            </td>
                        </tr>
                    @else
                        @foreach ($sphs as $item)
                            <tr>
                                <td class="px-4 py-3">{{ $item->tender->nama_tender }}</td>
                                <td class="px-4 py-3">
                                    <flux:button icon="arrow-down-tray" class="mr-2"
                                        wire:click="download({{ $item->id }})"></flux:button>
                                </td>
                                <td class="px-4 py-3">
                                    {{ $item->user->name }}
                                </td>
                                <td>
                                    @if ($item->status === 0 && $item->keterangan !== null)
                                        {{-- kondisi jika ada revisi --}}
                                        <flux:modal.trigger name="edit-sph-{{ $item->id }}">
                                            @if ($item->latestWorkflow?->waktu_pesan_dibaca === null)
                                                {{-- BELUM DIBACA --}}
                                                <flux:button icon="envelope" class="mr-2"
                                                    wire:click="edit({{ $item->id }})" variant="primary"
                                                    color="red">
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
                                        <flux:modal name="edit-sph-{{ $item->id }}">
                                            <flux:field>
                                                <flux:label class="mt-3">Pesan Revisi</flux:label>
                                                <flux:text class=" text-left">{{ $item->pesan_revisi }}</flux:text>
                                            </flux:field>
                                            <form wire:submit.prevent="update">
                                                <flux:field>
                                                    <flux:label class="mt-3">Nama Surat Penawaran Harga</flux:label>
                                                    <flux:text class=" text-left">{{ $item->nama_sph }}</flux:text>

                                                    {{-- <flux:input wire:model="nama_sph" />
                                                @error('nama_sph')
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
                                                    <flux:label class="mt-3">Upload SPH Revisi</flux:label>
                                                    <flux:input type="file" wire:model="file_path_sph" />
                                                    @error('file_path_sph')
                                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                                    @enderror
                                                </flux:field>

                                                <flux:modal.trigger name="revisi-sph">
                                                    <flux:button class="mt-6" variant="primary" color="emerald"
                                                        wire:loading.attr="disabled" wire:target="file_path_sph">
                                                        Revisi
                                                    </flux:button>
                                                </flux:modal.trigger>

                                                <flux:modal name="revisi-sph" class="min-w-[22rem] text-left">
                                                    <div class="space-y-6">
                                                        <div>
                                                            <flux:heading size="lg">Revisi SPH?</flux:heading>
                                                            <flux:text class="mt-2">
                                                                Anda akan merevisi surat penawaran harga tersebut.<br>
                                                                Surat penawaran harga yang sudah direvisi akan diberikan ke
                                                                Manajer Teknik.
                                                            </flux:text>
                                                        </div>
                                                        <div class="flex gap-2">
                                                            <flux:spacer />
                                                            <flux:modal.close>
                                                                <flux:button variant="ghost">Batal</flux:button>
                                                            </flux:modal.close>
                                                            <flux:button type="submit" variant="primary"
                                                                color="emerald">
                                                                Yakin</flux:button>
                                                        </div>
                                                    </div>
                                                </flux:modal>
                                            </form>
                                        </flux:modal>
                                    @else
                                        {{-- kondisi belum di validasi --}}
                                        <flux:button icon="envelope" class="mr-2" variant="primary">
                                            {{ $item->keterangan ?? 'Surat Penawaran Harga belum diperiksa' }}
                                        </flux:button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>

            </table>

        </div>
    @endcan

    {{-- Static Pagination Info --}}
    <div class="pl-1 m-2">
        {{ $sphs->links() }}
    </div>
</div>
