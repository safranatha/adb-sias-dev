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
            <table class="w-full text-sm text-center bg-white">
                <thead class="bg-green-50 text-white">
                    <tr>
                        <th class="px-4 py-3 font-medium">
                            Nama Tender
                        </th>
                        <th class="px-4 py-3 font-medium text-center">
                            <div class="flex justify-center items-center">
                                <flux:dropdown>
                                    <div class="flex items-center gap-1">
                                        <flux:heading class="text-sm text-white mr-2">Nama Klien</flux:heading>
                                        <flux:button size="sm" class="[&>svg]:text-white [&>svg]:stroke-white"
                                            icon="chevron-down" variant="ghost" inset />
                                    </div>

                                    <flux:menu>
                                        <flux:menu.checkbox keep-open checked>Klien 1</flux:menu.checkbox>
                                        <flux:menu.checkbox keep-open>Klien 2</flux:menu.checkbox>
                                        <flux:menu.checkbox keep-open>Klien 3</flux:menu.checkbox>
                                        <flux:menu.separator />
                                        <flux:menu.item icon="trash" variant="danger">Bersihkan</flux:menu.item>
                                    </flux:menu>
                                </flux:dropdown>
                            </div>
                        </th>

                        <th class="px-4 py-3 font-medium text-center">
                            <div class="flex justify-center items-center">
                            <flux:dropdown>
                                <div class="flex items-center gap-1">
                                    <flux:heading class="text-sm text-white mr-2">Status</flux:heading>
                                    <flux:button size="sm" class="[&>svg]:text-white [&>svg]:stroke-white"
                                        icon="chevron-down" variant="ghost" inset />
                                </div>

                                <flux:menu>
                                    <flux:menu.checkbox keep-open checked>Berhasil</flux:menu.checkbox>
                                    <flux:menu.checkbox keep-open>Dalam Proses</flux:menu.checkbox>
                                    <flux:menu.checkbox keep-open>Gagal</flux:menu.checkbox>
                                    <flux:menu.separator />
                                    <flux:menu.item icon="trash" variant="danger">Bersihkan</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium">Edit</th>
                        <th class="px-4 py-3 font-medium">Dokumen Pra Kualifikasi</th>
                        <th class="px-4 py-3 font-medium">Detail</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @if ($tenders->isEmpty())
                        <tr class="text-center">
                            <td colspan="6" class="px-4 py-6">
                                Tidak ada tender untuk ditampilkan.
                            </td>
                        </tr>
                    @else
                        @foreach ($tenders as $item)
                            <tr>
                                <td class="px-4 py-3 text-center">{{ $item->nama_tender }}</td>
                                <td class="px-4 py-3 text-center">{{ $item->nama_klien }}</td>
                                <td class="px-4 py-3 text-center"> {{ $item->status }}</td>
                                <td class="px-4 py-3 text-center">
                                    <flux:modal.trigger name="edit-tender-{{ $item->id }}">
                                        <flux:button icon="pencil" class="mr-2"
                                            wire:click="edit({{ $item->id }})" variant="primary" color="yellow" />
                                    </flux:modal.trigger>

                                    <flux:modal name="edit-tender-{{ $item->id }}" class="max-w-2xl">
                                        <div class="space-y-4">

                                            <flux:field>
                                                <flux:label>Nama Tender</flux:label>
                                                <flux:input wire:model="nama_tender" />
                                                @error('nama_tender')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                            </flux:field>

                                            <flux:field>
                                                <flux:label>Nama Klien</flux:label>
                                                <flux:input wire:model="nama_klien" />
                                                @error('nama_klien')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                            </flux:field>

                                            {{-- Trigger KONFIRMASI --}}
                                            <flux:modal.trigger name="confirm-update-{{ $item->id }}">
                                                <flux:button class="mt-3 w-full" variant="primary" color="emerald">
                                                    Update
                                                </flux:button>
                                            </flux:modal.trigger>
                                        </div>
                                    </flux:modal>

                                    <flux:modal name="confirm-update-{{ $item->id }}" class="min-w-[22rem]">
                                        <form wire:submit.prevent="update">
                                            <div class="space-y-6 text-left">

                                                <div>
                                                    <flux:heading size="lg">Update tender?</flux:heading>
                                                    <flux:text class="mt-2">
                                                        Anda akan memperbarui tender tersebut.<br>
                                                        Apakah Anda yakin?
                                                    </flux:text>
                                                </div>

                                                <div class="flex gap-2">
                                                    <flux:spacer />

                                                    <flux:modal.close>
                                                        <flux:button type="button" variant="ghost">
                                                            Batal
                                                        </flux:button>
                                                    </flux:modal.close>

                                                    <flux:button type="submit" variant="primary" color="emerald">
                                                        Yakin
                                                    </flux:button>
                                                </div>
                                            </div>
                                        </form>
                                    </flux:modal>

                                <td class="px-4 py-3">
                                    <flux:button icon="arrow-down-tray" class="mr-2"
                                        wire:click="download({{ $item->id }})"></flux:button>
                                </td>

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
