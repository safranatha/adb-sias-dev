<div class="max-w-6xl mx-auto mt-8">
    @can('create proposal')
        <flux:modal.trigger name="store-proposal">
            <flux:button class="mb-4">Add Proposal</flux:button>
        </flux:modal.trigger>

        <flux:modal name="store-proposal" class="max-w-2xl">
            <form wire:submit.prevent="store">
                <flux:heading size="lg">Upload Proposal</flux:heading>
                {{-- Name Field --}}
                <flux:field>
                    <flux:label class="mt-3">Nama Proposal</flux:label>
                    <flux:input wire:model="nama_proposal" placeholder="Enter user name" />
                </flux:field>


                <flux:field>
                    <flux:label class="mt-3">File Proposal</flux:label>
                    <flux:input type="file" wire:model="file_path_proposal" />
                    @error('file_path_proposal')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
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
                <flux:button type="submit" class="mt-6" variant="primary">
                    Upload
                </flux:button>
            </form>
        </flux:modal>
    @endcan

    {{-- success message after post created --}}
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
                    <th class="px-4 py-3 font-medium">Nama Tender</th>
                    <th class="px-4 py-3 font-medium">Nama Proposal</th>
                    <th class="px-4 py-3 font-medium">File Proposal</th>
                    <th class="px-4 py-3 font-medium">Creator</th>
                    <th class="px-4 py-3 font-medium">Validator</th>
                    @can('validate proposal')
                        <th class="px-4 py-3 font-medium">Action</th>
                    @endcan
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @if ($proposals->isEmpty())
                    <tr>
                        <td colspan="3" class="px-4 py-6">
                            Tidak ada proposal untuk ditampilkan.
                        </td>
                    </tr>
                @else
                    @foreach ($proposals as $item)
                        <tr>
                            <td class="px-4 py-3">{{ $item->tender->nama_tender }}</td>
                            <td class="px-4 py-3">{{ $item->nama_proposal }}</td>
                            {{-- file proposal diberi logo download dan jika diklik maka auto download --}}
                            <td class="px-4 py-3">
                                <flux:button icon="arrow-down-tray" class="mr-2"
                                    wire:click="download({{ $item->id }})"></flux:button>
                            </td>
                            <td class="px-4 py-3">
                                {{ $item->user->name }}
                            </td>
                            <td class="px-4 py-3">
                                validator
                            </td>
                            @can('validate proposal')
                                <td class="px-4 py-3">
                                    <flux:button icon="check" class="mr-2" variant="primary" color="green">
                                    </flux:button>
                                    <flux:button icon="x-mark" variant="danger"></flux:button>
                                </td>
                            @endcan
                        </tr>
                    @endforeach

                @endif
            </tbody>
        </table>
        <div class=" pl-1 m-2">
            {{ $proposals->links() }}
        </div>
    </div>
</div>
