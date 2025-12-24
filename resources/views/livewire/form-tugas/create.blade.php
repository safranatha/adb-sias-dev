<div class="w-full">
    <div class="mb-5">
        <flux:heading size="xl">Buat Form Tugas</flux:heading>
        <flux:text class="mt-2">Buat Form Tugas dengan memasukkan data-data berikut.</flux:text>
    </div>

    <form wire:submit.prevent="store">
        <flux:field>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="col-span-1">
                    {{-- Penerima Selection --}}
                    <flux:label class="mt-3">Penerima</flux:label>
                    <flux:select wire:model="penerima" class="w-full">
                        <flux:select.option value="">-- Pilih penerima --</flux:select.option>
                        @foreach ($list_penerima as $item)
                            <flux:select.option value="{{ $item->id }}">
                                {{ $item->name }}
                            </flux:select.option>
                        @endforeach
                        @error('penerima')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </flux:select>
                </div>

                <div class="col-span-2">
                    {{-- Jenis Permintaan Field --}}
                    <flux:label class="mt-3">Jenis Permintaan</flux:label>
                    <flux:input wire:model="jenis_permintaan" class="w-full" />
                    @error('jenis_permintaan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

        </flux:field>

        {{-- Kegiatan Field --}}
        <flux:field>
            <flux:label class="mt-3">Kegiatan/Pekerjaan</flux:label>
            <flux:input wire:model="kegiatan" placeholder="Enter kegiatan" />
            @error('kegiatan')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </flux:field>

        <flux:field>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="col-span-2">
                    {{-- Lingkup Kerja Selection --}}
                    <flux:label class="mt-3">Lingkup Kerja</flux:label>

                    <flux:input wire:model="lingkup_kerja" class="w-full" />
                    @error('lingkup_kerja')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                </div>

                <div class="col-span-1">
                    {{-- due date Field --}}
                    <flux:label class="mt-3">Due Date</flux:label>
                    <flux:input type="date" max="2999-12-31" wire:model="due_date" />
                    @error('lingkup_kerja')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

        </flux:field>


        {{-- File Upload Field --}}
        <flux:field>
            <flux:label class="mt-3">Dokumen</flux:label>
            <flux:input type="file" wire:model="file_path_form_tugas" />
            @error('file_path_form_tugas')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </flux:field>

        {{-- Isi Internal Memo Field --}}
        <flux:field>
            <flux:label class="mt-3">Isi Internal Memo</flux:label>
            <flux:input wire:model="keterangan" placeholder="Enter keterangan" rows="6" />
            @error('keterangan')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </flux:field>

        <flux:spacer />

        <div class="flex gap-3 mt-6">
            <flux:button type="submit" variant="primary" color="emerald">
                Buat Form Tugas
            </flux:button>

            <flux:button variant="ghost" href="{{ route('form-tugas.index') }}">
                Batal
            </flux:button>
        </div>
    </form>
</div>
