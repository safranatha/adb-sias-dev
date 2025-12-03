<div class="max-w-6xl mx-auto mt-8">
    @can('create proposal')
    <flux:button class="mb-4">Add Proposal</flux:button>
    @endcan
    
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
