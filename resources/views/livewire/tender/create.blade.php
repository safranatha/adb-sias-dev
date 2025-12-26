@can('create tender')
    <div class="w-full">
        <div class="mb-5">
            <flux:heading size="xl">Buat Tender Baru</flux:heading>
            <flux:text class="mt-2">Buat tender baru dengan memasukkan data-data berikut.</flux:text>
        </div>
        <form wire:submit.prevent="store">
            {{-- Name Field --}}
            <flux:field>
                <flux:label class="mt-3">Nama Tender</flux:label>
                <flux:input wire:model="nama_tender" placeholder="Enter nama tender" />
            </flux:field>

            <flux:field>
                <flux:label class="mt-3">Nama Klien</flux:label>
                <flux:input wire:model="nama_klien" placeholder="Enter nama klien" />
            </flux:field>

            {{-- File Upload Field --}}
            <flux:field>
                <flux:label class="mt-3">File Pra Kualifikasi</flux:label>
                <flux:input type="file" wire:model="file_pra_kualifikasi" />
                {{-- Loading indicator saat upload --}}
                <div wire:loading wire:target="file_pra_kualifikasi" class="text-sm text-gray-500 mt-1">
                    Uploading file...
                </div>
                @error('file_pra_kualifikasi')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </flux:field>

            <flux:spacer />

            <div class="flex gap-3 mt-6">
                <flux:button type="submit" variant="primary" color="emerald">
                    Buat Tender
                </flux:button>

                <flux:button variant="ghost" href="{{ route('tender.index') }}">
                    Batal
                </flux:button>
            </div>

        </form>
    </div>
@else
    <div class="max-w-2xl mx-auto py-6">
        <flux:heading size="lg">Access Denied</flux:heading>
        <p class="mt-4">You don't have permission to create tenders.</p>
    </div>
@endcan
