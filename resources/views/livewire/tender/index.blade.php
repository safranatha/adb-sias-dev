<div>
    {{-- success message after post created --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
            x-transition:leave="transition ease-out duration-500" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="bg-green-100 text-green-800 px-4 py-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif
    <div>
        <div class="mb-5">
            <flux:heading size="xl">Daftar Tender</flux:heading>
            <flux:text class="mt-2">Berikut merupakan daftar Tender yang ada pada PT Adi Banuwa</flux:text>
        </div>

    <div class="overflow-x-auto rounded-md border border-gray-200">
        <table class="w-full text-sm text-center">
            <thead class="bg-green-50 text-white">
                <tr>
                    <th class="px-4 py-3 font-medium">Nama Tender</th>
                    <th class="px-4 py-3 font-medium">Nama Klien</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium">Edit</th>
                    <th class="px-4 py-3 font-medium">Detail</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @if ($tenders->isEmpty())
                    <tr>
                        <td colspan="3" class="px-4 py-6">
                            Tidak ada tender untuk ditampilkan.
                        </td>
                    </tr>
                @else
                    @foreach ($tenders as $item)
                        <tr>
                            <td class="px-4 py-3">{{ $item->nama_tender }}</td>
                            <td class="px-4 py-3">{{ $item->nama_klien }}</td>
                            <td class="px-4 py-3"> {{ $item->status }}</td>
                            <td class="px-4 py-3">
                                <flux:modal.trigger name="edit-tender-{{ $item->id }}">
                                    <flux:button icon="pencil" class="mr-2" wire:click="edit({{ $item->id }})"
                                        variant="primary" color="yellow"></flux:button>
                                </flux:modal.trigger>

                                <flux:modal name="edit-tender-{{ $item->id }}" class="max-w-2xl">
                                    <form wire:submit.prevent="update">
                                        <flux:field>
                                            <flux:label class="mt-3">Nama Tender</flux:label>
                                            <flux:input wire:model="nama_tender" />
                                            @error('nama_tender')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </flux:field>

                                        <flux:field>
                                            <flux:label class="mt-3">Nama Klien</flux:label>
                                            <flux:input wire:model="nama_klien" />
                                            @error('nama_klien')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </flux:field>



                                        <flux:button type="submit" class="mt-6" variant="primary">
                                            Update
                                        </flux:button>
                                    </form>
                                </flux:modal>
                            </td>
                            <td class="px-4 py-3">
                                <flux:button icon="information-circle" class="mr-2"
                                    href="{{ route('tender.detail', $item->id) }}"></flux:button>
                            </td>
                        </tr>
                    @endforeach

                @endif
            </tbody>
        </table>
        <div class=" pl-1 m-2">
            {{ $tenders->links() }}
        </div>
    </div>
</div>
