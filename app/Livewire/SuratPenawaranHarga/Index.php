<?php

namespace App\Livewire\SuratPenawaranHarga;

use App\Models\DocumentApprovalWorkflow;
use App\Models\SuratPenawaranHarga;
use App\Models\Tender;
use Livewire\Component;
use Livewire\WithPagination;



class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function download($id)
    {
        $sph = SuratPenawaranHarga::findOrFail($id);

        if (!$sph) {
            return session()->flash('error', 'Surat Penawaran Harga tidak ditemukan.');
        }

        $file_path = public_path('storage/' . $sph->file_path_sph);

        if (!file_exists($file_path)) {
            return session()->flash('error', 'File Surat Penawaran Harga tidak ditemukan di storage.');
        }

        return response()->download($file_path);
    }


    public function render()
    {
        return view('livewire.surat-penawaran-harga.index', [
            'sphs' => SuratPenawaranHarga::with(['tender', 'user', 'document_approval_workflows'])
                ->select('surat_penawaran_hargas.*')
                ->selectRaw("
                        EXISTS (
                            SELECT 1 
                            FROM document_approval_workflow daw 
                            WHERE daw.surat_penawaran_harga_id = surat_penawaran_hargas.id
                            AND daw.level IS NOT NULL
                        ) AS is_approved
                    ")
                ->orderBy('created_at', 'desc')
                ->paginate(5),

            'document_approvals' => DocumentApprovalWorkflow::with(['surat_penawaran_harga'])
                ->whereNotNull('surat_penawaran_harga_id')
                ->select('document_approval_workflow.*')
                ->orderBy('created_at', 'desc')
                ->paginate(5),

            'tenders' => Tender::where('status', 'Dalam Proses')
                ->doesntHave('surat_penawaran_harga')
                ->get(),
        ])->title('Surat Penawaran Harga');
    }
}
