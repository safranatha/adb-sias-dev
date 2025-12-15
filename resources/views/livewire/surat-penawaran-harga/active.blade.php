<div>
    {{-- Success/Error Messages --}}
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

    {{-- Header Section --}}
    <div class="mb-5">
        <flux:heading size="xl">SPH Aktif</flux:heading>
        <flux:text class="mt-2">Berikut merupakan daftar SPH Tender yang belum disetujui oleh Manajer Admin</flux:text>
    </div>

    {{-- Table Section --}}
    <div class="overflow-x-auto rounded-md border border-gray-200">
        <table class="w-full text-sm text-center">
            <thead class="bg-green-700 text-white">
                <tr>
                    <th class="px-4 py-3 font-medium">Nama SPH</th>
                    <th class="px-4 py-3 font-medium">File SPH</th>
                    <th class="px-4 py-3 font-medium">Dibuat Oleh</th>
                    <th class="px-4 py-3 font-medium">Validate</th>
                    <th class="px-4 py-3 font-medium">Validator</th>
                    <th class="px-4 py-3 font-medium">Status SPH</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                {{-- Dummy Data Row 1 --}}
                <tr>
                    <td class="px-4 py-3">Tender Pengadaan Alat Berat</td>
                    <td class="px-4 py-3">
                        <flux:button icon="arrow-down-tray" size="sm"></flux:button>
                    </td>
                    <td class="px-4 py-3">Ahmad Rizki</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2 justify-center">
                            <flux:button icon="check" size="sm" variant="primary" color="green"></flux:button>
                            <flux:button icon="x-mark" size="sm" variant="danger"></flux:button>
                        </div>
                    </td>
                    <td class="px-4 py-3">-</td>
                    <td class="px-4 py-3">
                        <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-md">
                            Proposal Baru
                        </span>
                    </td>
                </tr>

                {{-- Dummy Data Row 2 --}}
                <tr>
                    <td class="px-4 py-3">Proyek Pembangunan Jembatan</td>
                    <td class="px-4 py-3">
                        <flux:button icon="arrow-down-tray" size="sm"></flux:button>
                    </td>
                    <td class="px-4 py-3">Siti Nurhaliza</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2 justify-center">
                            <flux:button icon="check" size="sm" variant="primary" color="green"></flux:button>
                            <flux:button icon="x-mark" size="sm" variant="danger"></flux:button>
                        </div>
                    </td>
                    <td class="px-4 py-3">-</td>
                    <td class="px-4 py-3">
                        <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-md">
                            Proposal Baru
                        </span>
                    </td>
                </tr>

                {{-- Dummy Data Row 3 --}}
                <tr>
                    <td class="px-4 py-3">Tender Pengadaan Peralatan Kantor</td>
                    <td class="px-4 py-3">
                        <flux:button icon="arrow-down-tray" size="sm"></flux:button>
                    </td>
                    <td class="px-4 py-3">Budi Santoso</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2 justify-center">
                            <flux:button icon="check" size="sm" variant="primary" color="green"></flux:button>
                            <flux:button icon="x-mark" size="sm" variant="danger"></flux:button>
                        </div>
                    </td>
                    <td class="px-4 py-3">-</td>
                    <td class="px-4 py-3">
                        <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-md">
                            Proposal Baru
                        </span>
                    </td>
                </tr>

                {{-- Dummy Data Row 4 --}}
                <tr>
                    <td class="px-4 py-3">Renovasi Gedung Kantor Pusat</td>
                    <td class="px-4 py-3">
                        <flux:button icon="arrow-down-tray" size="sm"></flux:button>
                    </td>
                    <td class="px-4 py-3">Dewi Lestari</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2 justify-center">
                            <flux:button icon="check" size="sm" variant="primary" color="green"></flux:button>
                            <flux:button icon="x-mark" size="sm" variant="danger"></flux:button>
                        </div>
                    </td>
                    <td class="px-4 py-3">-</td>
                    <td class="px-4 py-3">
                        <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-md">
                            Proposal Baru
                        </span>
                    </td>
                </tr>

                {{-- Dummy Data Row 5 --}}
                <tr>
                    <td class="px-4 py-3">Pengadaan Software Manajemen</td>
                    <td class="px-4 py-3">
                        <flux:button icon="arrow-down-tray" size="sm"></flux:button>
                    </td>
                    <td class="px-4 py-3">Rudi Hermawan</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2 justify-center">
                            <flux:button icon="check" size="sm" variant="primary" color="green"></flux:button>
                            <flux:button icon="x-mark" size="sm" variant="danger"></flux:button>
                        </div>
                    </td>
                    <td class="px-4 py-3">-</td>
                    <td class="px-4 py-3">
                        <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-md">
                            Proposal Baru
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
        
        {{-- Static Pagination Info --}}
        <div class="pl-1 m-2">
            <p class="text-sm text-gray-600">Showing 5 of 5 results</p>
        </div>
    </div>
</div>
