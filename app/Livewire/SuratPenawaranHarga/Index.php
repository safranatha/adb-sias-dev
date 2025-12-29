<?php

namespace App\Livewire\SuratPenawaranHarga;

use App\Helpers\DokumenTenderHelper;
use App\Models\SuratPenawaranHarga;
use Livewire\Component;
use Livewire\WithPagination;



class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function download($id)
    {
        return DokumenTenderHelper::downloadHelper(SuratPenawaranHarga::class, $id, 'file_path_sph', 'Surat Penawaran Harga');
    }


    public function render()
    {
        return view('livewire.surat-penawaran-harga.index', [
            'sphs' => SuratPenawaranHarga::whereHas('document_approval_workflows', function ($query) {
                $query->where('status', '!=', null);
            })
                ->orderBy('created_at', 'desc')
                ->paginate(5),

        ])->title('Surat Penawaran Harga');
    }
}
