<div>

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
            x-transition:leave="transition ease-out duration-500" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="bg-red-100 text-red-800 px-4 py-2 rounded mb-3">
            {{ session('error') }}
        </div>
    @endif

    <flux:heading size="xl">Detail Tender {{ $tender->nama_tender }}</flux:heading>
    <flux:text class="mt-2">Berikut merupakan detail dari Tender {{ $tender->nama_tender }}.</flux:text>

    <!-- Baris 1 -->
    <div class="flex gap-4 mt-6">
        <div class="color-white bg-white p-5 rounded-lg shadow-md flex w-full">
            <div>
                <flux:icon name="building-office" class="text-gray-400 size-12" />
            </div>
            <div>
                <flux:heading size="lg" class="ml-4">Nama Klien</flux:heading>
                <flux:text size="md" class="ml-4 mt-2">{{ $tender->nama_klien }}</flux:text>
            </div>
        </div>
        <div class="color-white bg-white p-5 rounded-lg shadow-md flex w-full">
            <div>
                <flux:icon name="clipboard-document-list" class="text-gray-400 size-12" />
            </div>
            <div>
                <flux:heading size="lg" class="ml-4">Status Tender</flux:heading>
                <flux:text size="md" class="ml-4 mt-2">{{ $tender->status }} </flux:text>
            </div>
            <div class="content-center ml-auto">
                <flux:modal.trigger name="edit-status-tender">
                    <flux:button variant="primary" color="yellow" icon="pencil"
                        wire:click="editStatus({{ $tender->id }})" />
                </flux:modal.trigger>

                <flux:modal name="edit-status-tender" class="max-w-3xl">
                    <form wire:submit.prevent="update_status_tender">
                        <div class=" space-y-3">
                            <flux:heading size="lg">Edit Status Tender</flux:heading>

                            <flux:select wire:model.live="status" placeholder="--Pilih Status--">
                                <flux:select.option value="Gagal">Gagal</flux:select.option>
                                <flux:select.option value="Berhasil">Berhasil</flux:select.option>
                                <flux:select.option value="Dalam Proses">Dalam Proses</flux:select.option>

                            </flux:select>
                        </div>

                        <div class="flex justify-end">
                            <flux:modal.trigger name="confirm-edit-status-tender">
                                <flux:button variant="primary" color="emerald" class="w-full mt-10">
                                    Simpan
                                </flux:button>
                            </flux:modal.trigger>

                            <flux:modal name="confirm-edit-status-tender" class="min-w-[22rem]">
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">Konfirmasi Perubahan Status Tender?</flux:heading>
                                        <flux:text class="mt-2">
                                            Anda akan mengubah status tender ini.<br>
                                            Tindakan ini tidak dapat dibatalkan.
                                        </flux:text>
                                    </div>
                                    <div class="flex gap-2">
                                        <flux:spacer />
                                        <flux:modal.close>
                                            <flux:button variant="ghost">Batal</flux:button>
                                        </flux:modal.close>
                                        <flux:button type="submit" variant="danger">Ubah Status</flux:button>
                                    </div>
                                </div>
                            </flux:modal>
                        </div>
                    </form>
                </flux:modal>
            </div>
        </div>
    </div>

    <!-- Baris 2 -->
    <div class="flex gap-4 mt-6">
        <div class="color-white bg-white p-5 rounded-lg shadow-md flex w-full">
            <div>
                <flux:icon name="document-text" class="text-gray-400 size-12" />
            </div>
            <div>
                <flux:heading size="lg" class="ml-4">Dokumen Proposal Tender</flux:heading>
                <flux:text size="md" class="ml-4 mt-2">
                    {{ $tender->proposal->keterangan ?? 'Sedang dalam pengerjaan' }}</flux:text>
            </div>
            <div class="content-center ml-auto">
                @if ($tender->status_tender == 'Gagal')
                    <flux:button variant="danger" disabled icon="x-mark">Tender Gagal</flux:button>
                @elseif ($tender->status_tender == 'Berhasil')
                    <flux:button variant="primary" color="emerald" icon="arrow-down-tray"
                        wire:click="get_data_proposal({{ $tender->id }})">Proposal Final</flux:button>
                @elseif (
                    $tender->level_propo == 'Proposal ditolak oleh Direktur' ||
                        $tender->level_propo == 'Proposal telah disetujui Manajer Teknik' ||
                        $tender->level_propo == 'Proposal telah disetujui Direktur')
                    <flux:button variant="primary" color="emerald" icon="arrow-down-tray"
                        wire:click="get_data_proposal({{ $tender->id }})"></flux:button>
                @else
                    <flux:button variant="ghost" color="gray" disabled icon="arrow-down-tray"></flux:button>
                @endif
            </div>
        </div>
        @if ($tender->status_tender == 'Gagal')
            <div class="color-white bg-red-500 p-5 rounded-lg shadow-md flex">
                <flux:icon name="x-circle" class="text-red-50 size-12" />
                <flux:text size="md" class="ml-4 mt-2 text-accent-content">Tender Gagal</flux:text>
            </div>
        @elseif($tender->status_tender == 'Berhasil')
            <div class="color-white bg-green-500 p-5 rounded-lg shadow-md flex">
                <flux:icon name="check-circle" class="text-amber-50 size-12" />
                <flux:text size="md" class="ml-4 mt-2 text-amber-50">Tender Berhasil</flux:text>
            </div>
        @elseif ($tender->level_propo == 'Proposal telah disetujui Direktur')
            <div class="color-white bg-green-200 p-5 rounded-lg shadow-md flex">
                <flux:icon name="check-circle" class="text-green-50 size-12" />
                <flux:text size="md" class="ml-4 mt-2">Sudah diperiksa</flux:text>
            </div>
        @elseif($tender->level_propo == 'Proposal ditolak oleh Direktur')
            <div class="color-white bg-red-500 p-5 rounded-lg shadow-md flex">
                <flux:icon name="x-circle" class="text-red-50 size-12" />
                <flux:text size="md" class="ml-4 mt-2 text-accent-content">Ditolak Direktur</flux:text>
            </div>
        @elseif ($tender->level_propo == 'Proposal telah disetujui Manajer Teknik')
            <div class="color-white bg-green-100 p-5 rounded-lg shadow-md flex">
                <div class="content-center">
                    <flux:button icon="check" class="" wire:click="approve_proposal({{ $tender->id }})"
                        variant="primary" color="green"></flux:button>
                </div>
            </div>
            <div class="color-white bg-red-100 p-5 rounded-lg shadow-md flex">
                <div class="content-center">
                    <flux:modal.trigger name="reject-proposal-{{ $tender->id }}">
                        <flux:button icon="x-mark" class="" wire:click="" variant="danger"></flux:button>
                    </flux:modal.trigger>

                    {{-- modal form reject --}}
                    <flux:modal name="reject-proposal-{{ $tender->id }}" class="max-w-3xl content-center">
                        <form wire:submit.prevent="reject_proposal({{ $tender->id }})">
                            <flux:field>
                                <flux:label class="mt-3">Alasan Penolakan</flux:label>
                                <flux:input type="file" wire:model="file_path_revisi" />
                                {{-- Loading indicator saat upload --}}
                                <div wire:loading wire:target="file_path_revisi" class="text-sm text-gray-500 mt-1">
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
                            <flux:modal.trigger name="reject-proposal-confirmation">
                                <flux:button class="mt-6 w-full" variant="danger" wire:loading.attr="disabled"
                                    wire:target="file_path_revisi">
                                    Tolak
                                </flux:button>
                            </flux:modal.trigger>
                            <flux:modal name="reject-proposal-confirmation" class="min-w-[22rem]">
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">Tolak Proposal?</flux:heading>
                                        <flux:text class="mt-2">
                                            Anda akan menolak proposal tersebut.<br>
                                            Proposal yang sudah ditolak akan diberikan ke Staff.
                                        </flux:text>
                                    </div>
                                    <div class="flex gap-2">
                                        <flux:spacer />
                                        <flux:modal.close>
                                            <flux:button variant="ghost">Batal</flux:button>
                                        </flux:modal.close>
                                        <flux:button type="submit" variant="danger">Tolak Proposal</flux:button>
                                    </div>
                                </div>
                            </flux:modal>
                        </form>
                    </flux:modal>
                </div>
            </div>
        @else
            <div class="color-white bg-zinc-100 p-5 rounded-lg shadow-md flex">
                <div class="content-center">
                    <flux:button icon="check" disabled variant="ghost"></flux:button>
                </div>
            </div>
            <div class="color-white bg-zinc-100 p-5 rounded-lg shadow-md flex">
                <div class="content-center">
                    <flux:button icon="x-mark" disabled variant="ghost"></flux:button>
                </div>
            </div>
        @endif
    </div>

    <!-- Baris 3 -->
    <div class="flex gap-4 mt-6">
        <div class="color-white bg-white p-5 rounded-lg shadow-md flex w-full">
            <div>
                <flux:icon name="envelope" class="text-gray-400 size-12" />
            </div>
            <div>
                <flux:heading size="lg" class="ml-4">Dokumen Surat Penawaran Harga</flux:heading>
                <flux:text size="md" class="ml-4 mt-2">
                    {{ $tender->surat_penawaran_harga->keterangan ?? 'Sedang dalam pengerjaan' }}</flux:text>
            </div>
            <div class="content-center ml-auto">
                @if ($tender->status_tender == 'Gagal')
                    <flux:button variant="danger" disabled icon="x-mark">Tender Gagal</flux:button>
                @elseif ($tender->status_tender == 'Berhasil')
                    <flux:button variant="primary" color="emerald" icon="arrow-down-tray"
                        wire:click="get_data_SPH({{ $tender->id }})">SPH Final</flux:button>
                @elseif (
                    $tender->level_sph == 'SPH ditolak oleh Direktur' ||
                        $tender->level_sph == 'SPH telah disetujui Manajer Admin' ||
                        $tender->level_sph == 'SPH telah disetujui Direktur')
                    <flux:button variant="primary" color="emerald" icon="arrow-down-tray"
                        wire:click="get_data_SPH({{ $tender->id }})"></flux:button>
                @else
                    <flux:button variant="ghost" color="gray" disabled icon="arrow-down-tray"></flux:button>
                @endif
            </div>
        </div>
        @if ($tender->status_tender == 'Gagal')
            <div class="color-white bg-red-500 p-5 rounded-lg shadow-md flex">
                <flux:icon name="x-circle" class="text-red-50 size-12" />
                <flux:text size="md" class="ml-4 mt-2 text-accent-content">Tender Gagal</flux:text>
            </div>
        @elseif($tender->status_tender == 'Berhasil')
            <div class="color-white bg-green-500 p-5 rounded-lg shadow-md flex">
                <flux:icon name="check-circle" class="text-amber-50 size-12" />
                <flux:text size="md" class="ml-4 mt-2 text-amber-50">Tender Berhasil</flux:text>
            </div>
        @elseif ($tender->level_sph == 'SPH telah disetujui Direktur')
            <div class="color-white bg-green-200 p-5 rounded-lg shadow-md flex">
                <flux:icon name="check-circle" class="text-green-50 size-12" />
                <flux:text size="md" class="ml-4 mt-2">Sudah diperiksa</flux:text>
            </div>
        @elseif($tender->level_sph == 'SPH ditolak oleh Direktur')
            <div class="color-white bg-red-500 p-5 rounded-lg shadow-md flex">
                <flux:icon name="x-circle" class="text-red-50 size-12" />
                <flux:text size="md" class="ml-4 mt-2 text-accent-content">Ditolak Direktur</flux:text>
            </div>
        @elseif ($tender->level_sph == 'SPH telah disetujui Manajer Admin')
            <div class="color-white bg-green-100 p-5 rounded-lg shadow-md flex">
                <div class="content-center">
                    <flux:button icon="check" class="" wire:click="approve_sph({{ $tender->id }})"
                        variant="primary" color="green"></flux:button>
                </div>
            </div>
            <div class="color-white bg-red-100 p-5 rounded-lg shadow-md flex">
                <div class="content-center">
                    <flux:modal.trigger name="reject-sph-{{ $tender->id }}">
                        <flux:button icon="x-mark" class="" wire:click="" variant="danger"></flux:button>
                    </flux:modal.trigger>

                    {{-- modal form reject --}}
                    <flux:modal name="reject-sph-{{ $tender->id }}" class="max-w-3xl content-center">
                        <form wire:submit.prevent="reject_sph({{ $tender->id }})">
                            <flux:field>
                                <flux:label class="mt-3">Alasan Penolakan</flux:label>
                                <flux:input type="file" wire:model="file_path_revisi" />
                                {{-- Loading indicator saat upload --}}
                                <div wire:loading wire:target="file_path_revisi" class="text-sm text-gray-500 mt-1">
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
                            <flux:modal.trigger name="confirmation-reject-sph">
                                <flux:button class="mt-6 w-full" variant="danger" wire:loading.attr="disabled"
                                    wire:target="file_path_revisi">
                                    Tolak
                                </flux:button>
                            </flux:modal.trigger>
                            <flux:modal name="confirmation-reject-sph">
                                <div class="p-4">
                                    <flux:heading size="lg">Konfirmasi Penolakan</flux:heading>
                                    <flux:text class="mt-2">Anda yakin ingin menolak Surat Penawaran Harga ini?
                                        <br />
                                        SPH yang ditolak akan diberikan kepada Staff.
                                    </flux:text>
                                </div>
                                <div class="flex justify-end">
                                    <flux:modal.close>
                                        <flux:button variant="ghost">Batal</flux:button>
                                    </flux:modal.close>
                                    <flux:button type="submit" class="ml-2" variant="danger"
                                        wire:loading.attr="disabled" wire:target="file_path_revisi">
                                        Tolak SPH
                                    </flux:button>
                                </div>
                            </flux:modal>
                        </form>
                    </flux:modal>
                </div>
            </div>
        @else
            <div class="color-white bg-zinc-100 p-5 rounded-lg shadow-md flex">
                <div class="content-center">
                    <flux:button icon="check" class="" disabled variant="ghost"></flux:button>
                </div>
            </div>
            <div class="color-white bg-zinc-100 p-5 rounded-lg shadow-md flex">
                <div class="content-center">
                    <flux:button icon="x-mark" disabled variant="ghost"></flux:button>
                </div>
            </div>
        @endif
    </div>
</div>
