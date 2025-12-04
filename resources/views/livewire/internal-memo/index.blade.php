<div>
    <div class="max-w-6xl mx-auto mt-8">
        @can('create internal memo')
            <flux:modal.trigger name="store-internal-memo">
                <flux:button class="mb-4">Add Internal Memo</flux:button>
            </flux:modal.trigger>

            <flux:modal name="store-internal-memo" class="max-w-2xl">
                <form wire:submit.prevent="store" class="space-y-6 p-2">
                    <flux:heading size="lg">Upload Internal Memo</flux:heading>
                    {{-- Name Field --}}
                    <flux:field>
                        <flux:label>Judul Memo</flux:label>
                        <flux:input wire:model="nama_internal_memo" placeholder="Masukkan nama internal memo"></flux:input>
                    </flux:field>

                    <flux:field>
                        <flux:label>Isi Memo</flux:label>
                        <flux:textarea wire:model="isi_internal_memo" placeholder="Masukkan isi internal memo"></flux:textarea>
                    </flux:field>

                    <flux:field>
                        <flux:label class="mt-3">Tender</flux:label>
                        <flux:select wire:model="tender_id">
                            <flux:select.option value="">-- Pilih Tender --</flux:select.option>
                            @foreach ($tenders as $tender)
                                <flux:select.option value="{{ $tender->id }}">
                                    {{ $tender->nama_tender }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>

                        @error('tender_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </flux:field>

                    <flux:spacer />
                    <flux:button type="submit" variant="primary">
                        Upload
                    </flux:button>
                </form>
            </flux:modal>
        @endcan

        {{-- success message after internal memo created --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-3 successMsg">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    document.getElementsByClassName('successMsg')?.remove();
                }, 200);
            </script>
        @endif
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="w-full text-sm text-center">
                <thead class="bg-gray-100 text-black">
                    <tr>
                        <th class="px-4 py-3 font-medium">Judul Memo</th>
                        <th class="px-4 py-3 font-medium">Isi Memo</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @if ($internalMemos->isEmpty())
                        <tr>
                            <td colspan="2" class="px-4 py-6">
                                Tidak ada internal memo untuk ditampilkan.
                            </td>
                        </tr>
                    @else
                        @foreach ($internalMemos as $memo)
                            <tr>
                                <td class="px-4 py-3">{{ $memo->nama_internal_memo }}</td>
                                <td class="px-4 py-3">{{ $memo->isi_internal_memo }}</td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
