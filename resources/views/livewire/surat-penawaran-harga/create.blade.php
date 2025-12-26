@can('create surat penawaran harga')
        <div class="w-full">
            <div class="mb-5">
                <flux:heading size="xl">Buat Surat Penawaran Harga</flux:heading>
                <flux:text class="mt-2">Buat surat penawaran harga dengan memasukkan data-data berikut.</flux:text>
            </div>
            
            <form wire:submit.prevent="store">
                {{-- Nama Surat Field --}}
                <flux:field>
                    <flux:label class="mt-3">Nama Surat Penawaran Harga</flux:label>
                    <flux:input wire:model="nama_sph" placeholder="Enter nama surat" />
                    @error('nama_sph')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </flux:field>

                {{-- File Upload Field --}}
                <flux:field>
                    <flux:label class="mt-3">File Surat Penawaran Harga</flux:label>
                    <flux:input type="file" wire:model="file_path_sph" />
                    @error('file_path_sph')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </flux:field>

                {{-- Tender Selection --}}
                <flux:field>
                    <flux:label class="mt-3">Tender</flux:label>
                    <flux:select wire:model="tender_id">
                        <flux:select.option value="">-- Pilih Tender --</flux:select.option>
                        @foreach ($tender_status as $tender)
                            <flux:select.option value="{{ $tender->id }}">
                                {{ $tender->nama_klien }} - {{ $tender->nama_tender }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    @error('tender_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </flux:field>

                <flux:spacer />
                
                <div class="flex gap-3 mt-6">
                    <flux:button type="submit" variant="primary" color="emerald">
                        Buat Surat Penawaran Harga
                    </flux:button>
                    
                    <flux:button variant="ghost" href="{{ route('surat-penawaran-harga.index') }}">
                        Batal
                    </flux:button>
                </div>
            </form>
        </div>
@else
        <div class="max-w-2xl mx-auto py-6">
            <flux:heading size="lg">Access Denied</flux:heading>
            <p class="mt-4">You don't have permission to create surat penawaran harga.</p>
        </div>
@endcan