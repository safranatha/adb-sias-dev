<div>
    <div class="max-w-6xl mx-auto mt-8">
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="w-full text-sm text-center">
                <thead class="bg-gray-100 text-black">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama Tender</th>
                        <th class="px-4 py-3 font-medium">Nama Klien</th>
                        <th class="px-4 py-3 font-medium">Status</th>
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
                                    <flux:button icon="information-circle" class="mr-2"></flux:button>
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

</div>
