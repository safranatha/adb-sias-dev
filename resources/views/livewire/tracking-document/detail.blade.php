<div>
    <flux:heading size="xl">Detail Tracking Tender</flux:heading>
    <flux:text class="mt-2">Berikut merupakan detail tracking tender pada PT Adi Banuwa</flux:text>
    <flux:link as="button" class="text-accent text-xl mt-3" wire:click="backToIndex">← Kembali</flux:link>
    <div class="rounded-xl outline-2 outline-green-50">
        <div class="bg-white p-5 outline-green-50 mt-5">
            <div class="flex justify-between mx-auto">
                <div class="flex gap-4 items-center">
                    <flux:icon.document-text class="size-25" />
                    <div>
                        <flux:heading size="lg">Nama Tender</flux:heading>
                        <flux:text class="mt-2">PT Lorem Ipsum</flux:text>
                        <div class="mt-3 flex gap-5">
                            <div>
                                <flux:text>Tanggal Dibuat</flux:text>
                                <flux:badge variant="outline" color="green" class="mt-1">dd/mm/yyyy</flux:badge>
                            </div>
                            <div>
                                <flux:text>Status Tender</flux:text>
                                <flux:badge variant="outline" color="gray" class="mt-1">Lorem Ipsum</flux:badge>
                            </div>
                            <div>
                                <flux:text>ID Tender</flux:text>
                                <flux:badge variant="outline" color="blue" class="mt-1">xxx</flux:badge>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <flux:separator/>
        <div class="bg-white h-100 outline-green-50">
            
        </div>
    </div>
</div>
