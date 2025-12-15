<div>
    @can('create internal memo')
        <div class="w-full">
            <div class="mb-5">
                <flux:heading size="xl">Buat Internal Memo</flux:heading>
                <flux:text class="mt-2">Buat internal memo dengan memasukkan data-data berikut.</flux:text>
            </div>
            
            <form wire:submit.prevent="store">
                {{-- Tender Selection --}}
                <flux:field>
                    <flux:label class="mt-3">Tender</flux:label>
                    <flux:select wire:model="tender_id">
                        <flux:select.option value="">-- Pilih Tender --</flux:select.option>
                        @foreach ($tenders as $tender)
                            <flux:select.option value="{{ $tender->id }}">
                                {{ $tender->nama_tender }} - {{ $tender->nama_klien }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    @error('tender_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </flux:field>

                {{-- Nama Internal Memo Field --}}
                <flux:field>
                    <flux:label class="mt-3">Nama Internal Memo</flux:label>
                    <flux:input wire:model="nama_internal_memo" placeholder="Enter nama internal memo" />
                    @error('nama_internal_memo')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </flux:field>

                {{-- Isi Internal Memo Field --}}
                <flux:field>
                    <flux:label class="mt-3">Isi Internal Memo</flux:label>
                    <flux:textarea 
                        wire:model="isi_internal_memo" 
                        placeholder="Enter isi internal memo"
                        rows="6"
                    />
                    @error('isi_internal_memo')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </flux:field>

                <flux:spacer />
                
                <div class="flex gap-3 mt-6">
                    <flux:button type="submit" variant="primary" color="emerald">
                        Buat Internal Memo
                    </flux:button>
                    
                    <flux:button variant="ghost" href="{{ route('internal-memo.index') }}">
                        Batal
                    </flux:button>
                </div>
            </form>
        </div>
    @else
        <div class="max-w-2xl mx-auto py-6">
            <flux:heading size="lg">Access Denied</flux:heading>
            <p class="mt-4">You don't have permission to create internal memo.</p>
        </div>
    @endcan
</div>
