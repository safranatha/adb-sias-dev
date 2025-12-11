<div class="max-w-8xl mx-auto mt-8">
    @if (session('error'))
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
                    <th class="px-4 py-3 font-medium">Proposal</th>
                    <th class="px-4 py-3 font-medium">SPH</th>
                    <th class="px-4 py-3 font-medium">Status Proposal</th>
                    <th class="px-4 py-3 font-medium">Status SPH</th>
                    <th class="px-4 py-3 font-medium">Status Tender</th>
                    @if ($tender->status === 'Dalam Proses')
                        @can('create tender')
                            <th class="px-4 py-3 font-medium">Validate</th>
                        @endcan
                    @endif
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                <tr>
                    <td class="px-4 py-3">{{ $tender->nama_tender }}</td>
                    <td class="px-4 py-3">
                        <flux:button icon="arrow-down-tray" class="mr-2"
                            wire:click="get_data_proposal({{ $tender->id }})">
                        </flux:button>
                    </td>
                    <td class="px-4 py-3">
                        <flux:button icon="arrow-down-tray" class="mr-2"
                            wire:click="get_data_SPH({{ $tender->id }})">
                        </flux:button>
                    </td>
                    @if ($tender->status === 'Dalam Proses')
                        @can('validate proposal')
                            <td class="px-4 py-3">
                                <flux:button icon="check" class="mr-2" variant="primary" color="green">
                                </flux:button>
                                <flux:button icon="x-mark" variant="danger"></flux:button>
                            </td>
                        @endcan
                    @endif
                    <td class="px-4 py-3"> {{ $tender->proposal->keterangan ?? 'Sedang dalam pengerjaan' }}</td>
                    <td class="px-4 py-3"> {{ $tender->sph->keterangan ?? 'Sedang dalam pengerjaan' }}</td>

                    @if ($tender->status === true)
                        <td class="px-4 py-3">
                            <span class="bg-green-500 text-white text-s px-2 py-1 rounded-md">
                                Sudah diperiksa
                            </span>
                        </td>
                    @else
                        <td class="px-4 py-3">
                            {{-- validate proposal --}}
                            {{-- button approve --}}
                            <flux:button icon="check" class="mr-2" wire:click="approve({{ $tender->id }})"
                                variant="primary" color="green">
                            </flux:button>

                            {{-- button reject --}}
                            <flux:modal.trigger name="reject-proposal-{{ $tender->id }}">
                                <flux:button icon="x-mark" variant="danger"></flux:button>
                            </flux:modal.trigger>

                            {{-- modal form reject --}}
                            <flux:modal name="reject-proposal-{{ $tender->id }}">
                                <form wire:submit.prevent="reject({{ $tender->id }})">
                                    <flux:field>
                                        <flux:label class="mt-3">Alasan Penolakan</flux:label>
                                        <flux:textarea wire:model="pesan_revisi"></flux:textarea>
                                        @error('pesan_revisi')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </flux:field>
                                    <flux:button type="submit" class="mt-6" variant="danger">
                                        Tolak
                                    </flux:button>
                                </form>
                            </flux:modal>
                        </td>
                    @endif
                </tr>
            </tbody>
        </table>
    </div>
</div>
