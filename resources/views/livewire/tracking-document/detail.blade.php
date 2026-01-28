{{-- resources/views/tender/detail-tracking.blade.php --}}
<div>
    <flux:heading size="xl">Detail Tracking Tender</flux:heading>
    <flux:text class="mt-2">Berikut merupakan detail tracking tender pada PT Adi Banuwa</flux:text>
    <flux:link as="button" class="text-accent text-xl mt-3" wire:click="backToIndex">← Kembali</flux:link>

    <div class="rounded-xl overflow-hidden mt-5 shadow-sm outline-2 outline-green-50">
        {{-- Header Section --}}
        <div class="bg-white p-6">
            <div class="flex gap-4 items-start">
                <flux:icon.document-text class="size-12 text-emerald-600" />
                <div class="flex-1">
                    <flux:heading size="lg">Nama Tender</flux:heading>
                    <flux:text class="mt-2 text-lg">PT Lorem Ipsum</flux:text>
                    <div class="mt-4 flex gap-6">
                        <div>
                            <flux:text class="text-sm text-gray-600">Tanggal Dibuat</flux:text>
                            <flux:badge variant="outline" color="green" class="mt-1">dd/mm/yyyy</flux:badge>
                        </div>
                        <div>
                            <flux:text class="text-sm text-gray-600">Status Tender</flux:text>
                            <flux:badge variant="outline" color="gray" class="mt-1">Lorem Ipsum</flux:badge>
                        </div>
                        <div>
                            <flux:text class="text-sm text-gray-600">ID Tender</flux:text>
                            <flux:badge variant="outline" color="blue" class="mt-1">xxx</flux:badge>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <flux:separator />

        {{-- Flow Diagram Section --}}
        <div class="max-w-7xl mx-auto">
            <div class="relative rounded-lg p-8" style="height: 500px;">
                <svg class="absolute inset-0 w-full h-full" viewBox="0 0 1400 500" preserveAspectRatio="xMidYMid meet">

                    <!-- ===== MAIN LINE LEFT ===== -->
                    <line x1="200" y1="250" x2="320" y2="250" stroke="#10b981"
                        stroke-width="3" />
                    <line x1="320" y1="250" x2="440" y2="250" stroke="#4a5565"
                        stroke-width="3" />

                    <!-- ===== BRANCH UP ===== -->
                    <line x1="440" y1="250" x2="520" y2="150" stroke="#4a5565"
                        stroke-width="3" />
                    <line x1="520" y1="150" x2="640" y2="150" stroke="#4a5565"
                        stroke-width="3" />
                    <line x1="640" y1="150" x2="760" y2="150" stroke="#4a5565"
                        stroke-width="3" />
                    <line x1="760" y1="150" x2="840" y2="250" stroke="#4a5565"
                        stroke-width="3" />

                    <!-- ===== BRANCH DOWN ===== -->
                    <line x1="440" y1="250" x2="520" y2="350" stroke="#4a5565"
                        stroke-width="3" />
                    <line x1="520" y1="350" x2="640" y2="350" stroke="#4a5565"
                        stroke-width="3" />
                    <line x1="640" y1="350" x2="760" y2="350" stroke="#4a5565"
                        stroke-width="3" />
                    <line x1="760" y1="350" x2="840" y2="250" stroke="#4a5565"
                        stroke-width="3" />

                    <!-- ===== MAIN LINE RIGHT ===== -->
                    <line x1="840" y1="250" x2="960" y2="250" stroke="#4a5565"
                        stroke-width="3" />
                    <line x1="960" y1="250" x2="1080" y2="250" stroke="#4a5565"
                        stroke-width="3" />
                    <line x1="1080" y1="250" x2="1200" y2="250" stroke="#4a5565"
                        stroke-width="3" />

                    <!-- ===== CIRCLES ===== -->
                    <!-- left -->
                    <g>
                        <rect x="145" y="203" width="110" height="24" rx="6" fill="#10b981" />

                        <text x="200" y="195" text-anchor="middle" class="fill-gray-700 text-xs">
                            Tender Dibuat
                        </text>

                        <text x="200" y="220" text-anchor="middle" class="fill-white text-xs">
                            DD/MM/YYYY
                        </text>

                        <circle cx="200" cy="250" r="12" fill="#10b981" stroke="white"
                            stroke-width="3" />
                    </g>
                    <g>
                        <rect x="265" y="203" width="110" height="24" rx="6" fill="#4a5565" />

                        <text x="320" y="195" text-anchor="middle" class="fill-gray-700 text-xs">
                            Tugas Diberikan
                        </text>

                        <text x="320" y="220" text-anchor="middle" class="fill-white text-xs">
                            DD/MM/YYYY
                        </text>

                        <circle cx="320" cy="250" r="12" fill="#4a5565" stroke="white"
                            stroke-width="3" />
                    </g>

                    {{-- Bulat pemersatu --}}
                    <g>
                        <circle cx="440" cy="250" r="12" fill="#4a5565" stroke="white"
                            stroke-width="3" />
                    </g>

                    <!-- up -->
                    <g>
                        <rect x="465" y="103" width="110" height="24" rx="6" fill="#4a5565" />

                        <text x="520" y="120" text-anchor="middle" class="fill-white text-xs">
                            Proposal Tender
                        </text>

                        <circle cx="520" cy="150" r="12" fill="#4a5565" stroke="white"
                            stroke-width="3" />
                    </g>
                    <g>
                        <rect x="585" y="103" width="110" height="24" rx="6" fill="#4a5565" />

                        <text x="640" y="95" text-anchor="middle" class="fill-gray-700 text-xs">
                            Pengerjaan
                        </text>

                        <text x="640" y="120" text-anchor="middle" class="fill-white text-xs">
                            DD/MM/YYYY
                        </text>

                        <circle cx="640" cy="150" r="12" fill="#4a5565" stroke="white"
                            stroke-width="3" />
                    </g>

                    <g>
                        <rect x="705" y="103" width="110" height="24" rx="6" fill="#4a5565" />
                        <text x="760" y="95" text-anchor="middle" class="fill-gray-700 text-xs">
                            Disetujui Manager
                        </text>
                        <text x="760" y="120" text-anchor="middle" class="fill-white text-xs">
                            DD/MM/YYYY
                        </text>
                        <circle cx="760" cy="150" r="12" fill="#4a5565" stroke="white"
                            stroke-width="3" />
                    </g>

                    <!-- down -->
                    <g>
                        <rect x="465" y="370" width="110" height="24" rx="6" fill="#4a5565" />
                        <text x="520" y="386" text-anchor="middle" class="fill-white text-xs">
                            SPH Tender
                        </text>
                        <circle cx="520" cy="350" r="12" fill="#4a5565" stroke="white"
                            stroke-width="3" />
                    </g>

                    <g>
                        <rect x="585" y="370" width="110" height="24" rx="6" fill="#4a5565" />
                        <text x="640" y="386" text-anchor="middle" class="fill-white text-xs">
                            DD/MM/YYYY
                        </text>
                        <text x="640" y="410" text-anchor="middle" class="fill-black text-xs">
                            Pengerjaan
                        </text>
                        <circle cx="640" cy="350" r="12" fill="#4a5565" stroke="white"
                            stroke-width="3" />
                    </g>

                    <g>
                        <rect x="705" y="370" width="110" height="24" rx="6" fill="#4a5565" />
                        <text x="760" y="386" text-anchor="middle" class="fill-white text-xs">
                            DD/MM/YYYY
                        </text>
                        <text x="760" y="410" text-anchor="middle" class="fill-black text-xs">
                            Disetujui Manager
                        </text>
                        <circle cx="760" cy="350" r="12" fill="#4a5565" stroke="white"
                            stroke-width="3" />
                    </g>


                    {{-- Bulat pemersatu --}}
                    <g>
                        <circle cx="840" cy="250" r="12" fill="#4a5565" stroke="white"
                            stroke-width="3" />
                    </g>

                    <!-- right -->
                    <g>
                        <rect x="905" y="203" width="110" height="24" rx="6" fill="#4a5565" />
                        <text x="960" y="195" text-anchor="middle" class="fill-gray-700 text-xs">
                            Pengecekan Direktur
                        </text>
                        <text x="960" y="220" text-anchor="middle" class="fill-white text-xs">
                            DD/MM/YYYY
                        </text>
                        <circle cx="960" cy="250" r="12" fill="#4a5565" stroke="white"
                            stroke-width="3" />
                    </g>

                    <g>
                        <rect x="1025" y="203" width="110" height="24" rx="6" fill="#4a5565" />
                        <text x="1080" y="195" text-anchor="middle" class="fill-gray-700 text-xs">
                            Direktur Setuju
                        </text>
                        <text x="1080" y="220" text-anchor="middle" class="fill-white text-xs">
                            DD/MM/YYYY
                        </text>
                        <circle cx="1080" cy="250" r="12" fill="#4a5565" stroke="white"
                            stroke-width="3" />
                    </g>

                    <g>
                        <rect x="1145" y="203" width="110" height="24" rx="6" fill="#4a5565" />
                        <text x="1200" y="195" text-anchor="middle" class="fill-gray-700 text-xs">
                            Tender Selesai
                        </text>
                        <text x="1200" y="220" text-anchor="middle" class="fill-white text-xs">
                            DD/MM/YYYY
                        </text>
                        <circle cx="1200" cy="250" r="12" fill="#4a5565" stroke="white"
                            stroke-width="3" />
                    </g>
                </svg>
                <!-- ===== LEGEND ===== -->
                <div class="flex justify-center gap-8 text-sm text-gray-700">

                    <!-- Selesai -->
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded-full bg-emerald-500 inline-block"></span>
                        <span>Tahap Selesai / Aktif</span>
                    </div>

                    <!-- Belum diproses -->
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded-full bg-gray-600 inline-block"></span>
                        <span>Dalam Proses / Menunggu</span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
