<div>
    <div class="max-w-6xl mx-auto mt-8">
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="w-full text-sm text-center">
                <thead class="bg-gray-100 text-black">
                    <tr>
                        <th class="px-4 py-3 font-medium">Judul Memo</th>
                        <th class="px-4 py-3 font-medium">Isi Memo</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @if ($internalMemos->isEmpty())
                        <tr>
                            <td colspan="2" class="px-4 py-6">
                                Tidak ada internal memo untuk ditampilkan.
                            </td>
                        </tr>
                    @else
                        @foreach ($internalMemos as $memo)
                            <tr>
                                <td class="px-4 py-3">{{ $memo->judul_memo }}</td>
                                <td class="px-4 py-3">{{ $memo->isi_memo }}</td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
