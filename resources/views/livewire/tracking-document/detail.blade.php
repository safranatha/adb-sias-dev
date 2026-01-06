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
                    <svg class="absolute inset-0 w-full h-full" viewBox="0 0 1200 500"
                        preserveAspectRatio="xMidYMid meet">

                        <!-- ===== MAIN LINE LEFT ===== -->
                        
                        <line x1="200" y1="250" x2="320" y2="250" stroke="#10b981"
                            stroke-width="3" />
                        <line x1="320" y1="250" x2="440" y2="250" stroke="#10b981"
                            stroke-width="3" />

                        <!-- ===== BRANCH UP ===== -->
                        <line x1="440" y1="250" x2="520" y2="150" stroke="#10b981"
                            stroke-width="3" />
                        <line x1="520" y1="150" x2="640" y2="150" stroke="#10b981"
                            stroke-width="3" />
                        <line x1="640" y1="150" x2="760" y2="150" stroke="#10b981"
                            stroke-width="3" />
                        <line x1="760" y1="150" x2="840" y2="250" stroke="#10b981"
                            stroke-width="3" />

                        <!-- ===== BRANCH DOWN ===== -->
                        <line x1="440" y1="250" x2="520" y2="350" stroke="#10b981"
                            stroke-width="3" />
                        <line x1="520" y1="350" x2="640" y2="350" stroke="#10b981"
                            stroke-width="3" />
                        <line x1="640" y1="350" x2="760" y2="350" stroke="#10b981"
                            stroke-width="3" />
                        <line x1="760" y1="350" x2="840" y2="250" stroke="#10b981"
                            stroke-width="3" />

                        <!-- ===== MAIN LINE RIGHT ===== -->
                        <line x1="840" y1="250" x2="960" y2="250" stroke="#10b981"
                            stroke-width="3" />
                        <line x1="960" y1="250" x2="1080" y2="250" stroke="#10b981"
                            stroke-width="3" />

                        <!-- ===== CIRCLES ===== -->
                        <!-- left -->
                        <circle cx="200" cy="250" r="12" fill="#10b981" stroke="white"
                            stroke-width="3" />
                        <circle cx="320" cy="250" r="12" fill="#10b981" stroke="white"
                            stroke-width="3" />
                        <circle cx="440" cy="250" r="12" fill="#10b981" stroke="white"
                            stroke-width="3" />

                        <!-- up -->
                        <circle cx="520" cy="150" r="12" fill="#10b981" stroke="white"
                            stroke-width="3" />
                        <circle cx="640" cy="150" r="12" fill="#10b981" stroke="white"
                            stroke-width="3" />
                        <circle cx="760" cy="150" r="12" fill="#10b981" stroke="white"
                            stroke-width="3" />

                        <!-- down -->
                        <circle cx="520" cy="350" r="12" fill="#10b981" stroke="white"
                            stroke-width="3" />
                        <circle cx="640" cy="350" r="12" fill="#10b981" stroke="white"
                            stroke-width="3" />
                        <circle cx="760" cy="350" r="12" fill="#10b981" stroke="white"
                            stroke-width="3" />

                        <!-- right -->
                        <circle cx="840" cy="250" r="12" fill="#10b981" stroke="white"
                            stroke-width="3" />
                        <circle cx="960" cy="250" r="12" fill="#10b981" stroke="white"
                            stroke-width="3" />
                        <circle cx="1080" cy="250" r="12" fill="#10b981" stroke="white"
                            stroke-width="3" />

                    </svg>

                </div>
        </div>
    </div>
</div>
