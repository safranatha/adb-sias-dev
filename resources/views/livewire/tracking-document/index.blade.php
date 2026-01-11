<div>
    <flux:heading size="xl">Tracking Document</flux:heading>
    <flux:text class="mt-2">Cari dokumen tender Adi Banuwa</flux:text>

    <flux:separator class="mt-5 mb-5" />
    <div class="flex gap-4">
        <flux:button.group class="w-full flex">
            <div class="flex-[3]">
                <flux:input icon="magnifying-glass" wire:model.defer="searchInput" placeholder="Temukan Tender..."  
                {{-- wire:keydown.enter adalah event ketika tombol enter ditekan dan mengarah ke function searchTender yang ada di index.php --}}
                wire:keydown.enter="searchTender" />
            </div>

            {{-- <div class="flex-[1]">
                <flux:select size="md" placeholder="Cari berdasarkan...">
                    <flux:select.option>Nama Tender</flux:select.option>
                    <flux:select.option>Perusahaan Tender</flux:select.option>
                </flux:select>
            </div> --}}
        </flux:button.group>

        <flux:button variant="primary" class="w-32" color="emerald" wire:click="searchTender">
            Cari
        </flux:button>
    </div>

    @if ($search === '')
        <div class="text-center text-gray-400 mt-10">
            Silakan masukkan kata kunci lalu klik Cari
        </div>
    @endif

    <flux:separator class="mt-5 mb-5" />
    @if ($search !== '' && $tenders->isEmpty())
        <div class="text-center text-gray-400 mt-10">
            Data tidak ditemukan
        </div>
    @endif

    @if ($search !== '' && $tenders->isNotEmpty())
        @foreach ($tenders as $tender)
            <div class="bg-white p-5 rounded-xl outline-2 outline-green-50 mt-5">
                <div class="flex justify-between">
                    <div class="flex gap-4 items-center">
                        <flux:icon.document-text class="size-25" />
                        <div>
                            <flux:heading size="lg">{{ $tender->nama_tender }}</flux:heading>
                            <flux:text class="mt-2">{{ $tender->nama_klien }}</flux:text>

                            <div class="mt-3 flex gap-5">
                                <div>
                                    <flux:text>Tanggal Dibuat</flux:text>
                                    <flux:badge variant="outline" color="green">
                                        {{ $tender->created_at->format('d/m/Y') }}
                                    </flux:badge>
                                </div>

                                <div>
                                    <flux:text>ID Tender</flux:text>
                                    <flux:badge variant="outline" color="blue">
                                        {{ $tender->id }}
                                    </flux:badge>
                                </div>
                            </div>
                        </div>
                    </div>

                    <flux:button icon="magnifying-glass" variant="primary" color="emerald"
                        href="{{ route('tracking-document.detail', $tender->id) }}">
                        Detail Tender
                    </flux:button>
                </div>
            </div>
        @endforeach

        <div class="mt-5">
            {{ $tenders->links() }}
        </div>
    @endif
