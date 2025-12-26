@can('create proposal')
    <div class="w-full">
        <div class="mb-5">
            <flux:heading size="xl">Buat Proposal Baru</flux:heading>
            <flux:text class="mt-2">Buat proposal baru dengan memasukkan data-data berikut.</flux:text>
        </div>
        
        <form wire:submit.prevent="store">
            {{-- Nama Proposal Field --}}
            <flux:field>
                <flux:label class="mt-3">Nama Proposal</flux:label>
                <flux:input wire:model="nama_proposal" placeholder="Enter nama proposal" />
                @error('nama_proposal')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </flux:field>

            {{-- File Upload Field --}}
            <flux:field>
                <flux:label class="mt-3">File Proposal</flux:label>
                <flux:input type="file" wire:model="file_path_proposal" />
                @error('file_path_proposal')
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
                    Buat Proposal
                </flux:button>
                
                <flux:button variant="ghost" href="{{ route('proposal.index') }}">
                    Batal
                </flux:button>
            </div>
        </form>
    </div>
@else
    <div class="max-w-2xl mx-auto py-6">
        <flux:heading size="lg">Access Denied</flux:heading>
        <p class="mt-4">You don't have permission to create proposals.</p>
    </div>
@endcan
