@can('create tender')
    <div class="w-full">
        <div class="mb-5">
            <flux:heading size="xl">Buat Tender Baru</flux:heading>
            <flux:text class="mt-2">Buat tender baru dengan memasukkan data-data berikut.</flux:text>
        </div>
        <form wire:submit.prevent="store">
            {{-- Name Field --}}
            <flux:field>
                <flux:label class="mt-3">Nama Tender <x-required-badge /></flux:label>

                <flux:input wire:model="nama_tender" placeholder="Masukkan nama tender" />
            </flux:field>

            <flux:field>
                <flux:label class="mt-3">Nama Klien <x-required-badge /></flux:label>

                <flux:input wire:model="nama_klien" placeholder="Masukkan nama klien" />
            </flux:field>

            {{-- File Upload Field --}}
            <flux:field>
                <div class="bg-white p-5 rounded-2xl shadow-2xs mt-3">
                    <flux:label>File Pra Kualifikasi</flux:label>
                    <x-required-badge />
                    <flux:input type="file" wire:model="file_pra_kualifikasi" />
                    {{-- Loading indicator saat upload --}}
                    <div wire:loading wire:target="file_pra_kualifikasi" class="text-sm text-gray-500">
                        Uploading file...
                    </div>
                    @error('file_pra_kualifikasi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    <flux:description class="mt-2">Tipe Dokumen: .zip atau .pdf</flux:description>
            </flux:field>
    </div>

    <div class="flex gap-3 mt-5">
        <flux:modal.trigger name="submit-tender">
            <flux:button variant="primary" color="emerald" wire:loading.attr="disabled" wire:target="file_pra_kualifikasi">
                Buat Tender
            </flux:button>
        </flux:modal.trigger>


        <flux:modal name="submit-tender" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Buat tender?</flux:heading>
                    <flux:text class="mt-2">
                        Anda akan membuat tender tersebut.<br>
                        Tender yang sudah dibuat tidak dapat dihapus.
                    </flux:text>
                </div>
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Batal</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary" color="emerald">Yakin</flux:button>
                </div>
            </div>
        </flux:modal>
        <!-- <flux:button type="submit" variant="primary" color="emerald">
                                Buat Tender
                            </flux:button> -->

        <flux:button variant="ghost" href="{{ route('tender.index') }}">
            Batal
        </flux:button>
    </div>

    </form>
    </div>
@else
    <!-- <div class="max-w-2xl mx-auto py-6">
                    <flux:heading size="lg">Access Denied</flux:heading>
                    <p class="mt-4">You don't have permission to create tenders.</p>
                </div> -->
    @php abort(403); @endphp
@endcan
