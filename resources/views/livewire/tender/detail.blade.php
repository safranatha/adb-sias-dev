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
                    @if ($tender->status === 'Dalam Proses')
                        @can('validate proposal')
                            <th>Validate</th>
                        @endcan
                    @endif
                    <th class="px-4 py-3 font-medium">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                <tr>
                    <td class="px-4 py-3">{{ $tender->nama_tender }}</td>
                    <td class="px-4 py-3">
                        <flux:button icon="arrow-down-tray" class="mr-2" wire:click="getData({{ $tender->id }})">
                        </flux:button>
                    </td>
                    <td class="px-4 py-3">
                        <flux:button icon="arrow-down-tray" class="mr-2"></flux:button>
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
                    <td class="px-4 py-3"> {{ $tender->status }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
