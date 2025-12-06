<div class="max-w-8xl mx-auto mt-8" x-data="{
    closeModal(id) {
        if (id === 'store') {
            $flux.modal('store-sph').close();
        } else {
            $flux.modal('edit-sph-' + id).close();
        }
    }
}" @modal-closed.window="closeModal($event.detail.id)">


    @can('create surat penawaran harga')
        <flux:modal.trigger name="store-sph">
            <flux:button class="mb-4">Add Surat Penawaran Harga</flux:button>
        </flux:modal.trigger>

        <flux:modal name="store-sph" class="max-w-2xl">
            <form wire:submit.prevent="store">
                <flux:heading size="lg">Upload Surat Penawaran Harga</flux:heading>
                {{-- Name Field --}}
                <flux:field>
                    <flux:label class="mt-3">Nama Surat Penawaran Harga</flux:label>
                    <flux:input wire:model="nama_sph" placeholder="Enter user name" />
                </flux:field>


                <flux:field>
                    <flux:label class="mt-3">File Surate Penawaran Harga</flux:label>
                    <flux:input type="file" wire:model="file_path_sph" />
                    @error('file_path_sph')
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
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
            x-transition:leave="transition ease-out duration-500" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="bg-green-100 text-green-800 px-4 py-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
            x-transition:leave="transition ease-out duration-500" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="bg-red-100 text-red-800 px-4 py-2 rounded mb-3">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-gray-200">
        <table class="w-full text-sm text-center">
            <thead class="bg-gray-100 text-black">
                <tr>
                    <th class="px-4 py-3 font-medium">Nama Tender</th>
                    <th class="px-4 py-3 font-medium">Nama Surat Penawaran Harga</th>
                    <th class="px-4 py-3 font-medium">File Surat Penawaran Harga</th>
                    <th class="px-4 py-3 font-medium">Creator</th>
                    <th class="px-4 py-3 font-medium">Validator</th>
                    @can('validate surat penawaran harga')
                        <th class="px-4 py-3 font-medium">Validate</th>
                    @endcan
                    @can('create surat penawaran harga')
                        <th class="px-4 py-3 font-medium">Edit</th>
                    @endcan
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @if ($sphs->isEmpty())
                    <tr>
                        <td colspan="3" class="px-4 py-6">
                            Tidak ada Surat Penawaran Harga untuk ditampilkan.
                        </td>
                    </tr>
                @else
                    @foreach ($sphs as $item)
                        <tr>
                            <td class="px-4 py-3">{{ $item->tender->nama_tender }}</td>
                            <td class="px-4 py-3">{{ $item->nama_sph }}</td>
                            {{-- file sph diberi logo download dan jika diklik maka auto download --}}
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
                            @can('validate surat penawaran harga')
                                <td class="px-4 py-3">
                                    <flux:button icon="check" class="mr-2" variant="primary" color="green">
                                    </flux:button>
                                    <flux:button icon="x-mark" variant="danger"></flux:button>
                                </td>
                            @endcan

                            @can('create surat penawaran harga')
                                <td>
                                    <flux:modal.trigger name="edit-sph-{{ $item->id }}">
                                        <flux:button icon="pencil" class="mr-2" wire:click="edit({{ $item->id }})"
                                            variant="primary" color="yellow"></flux:button>
                                    </flux:modal.trigger>

                                    {{-- modal form --}}
                                    <flux:modal name="edit-sph-{{ $item->id }}">
                                        <form wire:submit.prevent="update">
                                            <flux:field>
                                                <flux:label class="mt-3">Nama Surat Penawaran Harga</flux:label>
                                                <flux:input wire:model="nama_sph" />
                                                @error('nama_sph')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                            </flux:field>

                                            <flux:field>
                                                <flux:label class="mt-3">File Surat Penawaran Harga</flux:label>

                                                @if ($file_path_sph)
                                                    <p class="text-sm mb-2">
                                                        File saat ini: {{ basename($file_path_sph) }}
                                                    </p>
                                                @endif
                                                <flux:input type="file" wire:model="file_path_sph" />
                                                @error('file_path_sph')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                            </flux:field>

                                            <flux:button type="submit" class="mt-6" variant="primary">
                                                Update
                                            </flux:button>
                                        </form>
                                    </flux:modal>
                                </td>
                            @endcan
                        </tr>
                    @endforeach

                @endif
            </tbody>
        </table>
        <div class=" pl-1 m-2">
            {{ $sphs->links() }}
        </div>
    </div>
</div>
