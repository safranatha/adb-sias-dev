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
            <div class="bg-white rounded-2xl mt-3 p-5 shadow-md">
            <flux:field>
                <flux:label>File Proposal</flux:label>
                <flux:input type="file" wire:model="file_path_proposal" />
            {{-- Loading indicator saat upload --}}
            <div wire:loading wire:target="file_path_proposal" class="text-sm text-gray-500 mt-1">
                Uploading file...
            </div>
                @error('file_path_proposal')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </flux:field>
            </div>

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
                <flux:modal.trigger name="submit-proposal">
                    <flux:button variant="primary" color="emerald" wire:loading.attr="disabled"
                    wire:target="file_path_proposal">Buat Proposal</flux:button>
                </flux:modal.trigger>

                <flux:modal name="submit-proposal" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Buat proposal?</flux:heading>
                            <flux:text class="mt-2">
                                Anda akan membuat proposal tersebut.<br>
                                Proposal yang sudah dibuat tidak dapat dihapus.
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

                <flux:button variant="ghost" href="{{ route('proposal.index') }}">
                    Batal
                </flux:button>
            </div>
        </form>
    </div>
@else
    <!-- <div class="max-w-2xl mx-auto py-6">
        <flux:heading size="lg">Access Denied</flux:heading>
        <p class="mt-4">You don't have permission to create proposals.</p>
    </div> -->
    @php abort(403); @endphp
@endcan
