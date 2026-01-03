<?php

namespace App\Livewire\Dashboard;

use App\Models\DocumentApprovalWorkflow;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ChartSph extends Component
{
    public function render()
    {
        $sph_belum_disetujui_manajer = DocumentApprovalWorkflow::whereNull('status')->where('level', '=', 0)->whereNotNull('surat_penawaran_harga_id')->count();

        $sph_ditolak_manajer =
            DocumentApprovalWorkflow::where('level', 2)
                ->where('status', 0)
                ->whereNotNull('surat_penawaran_harga_id')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('document_approval_workflow as daw2')
                        ->whereColumn('daw2.surat_penawaran_harga_id', 'document_approval_workflow.surat_penawaran_harga_id')
                        ->whereColumn('daw2.id', '>', 'document_approval_workflow.id');
                })
                ->count();

        $sph_sudah_disetujui_manajer =
            DocumentApprovalWorkflow::where('level', 2)
                ->where('status', 1)
                ->whereNotNull('surat_penawaran_harga_id')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('document_approval_workflow as daw2')
                        ->whereColumn('daw2.surat_penawaran_harga_id', 'document_approval_workflow.surat_penawaran_harga_id')
                        ->whereColumn('daw2.id', '>', 'document_approval_workflow.id')
                        ->where('daw2.level', 3);
                    // ->where('daw2.status', 0);
                })
                ->count('surat_penawaran_harga_id');

        $sph_ditolak_direktur =
            DocumentApprovalWorkflow::where('level', 3)
                ->where('status', 0)
                ->whereNotNull('surat_penawaran_harga_id')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('document_approval_workflow as daw2')
                        ->whereColumn('daw2.surat_penawaran_harga_id', 'document_approval_workflow.surat_penawaran_harga_id')
                        ->whereColumn('daw2.id', '>', 'document_approval_workflow.id');
                })
                ->count();

        $sph_sudah_disetujui_direktur =
            DocumentApprovalWorkflow::where('level', 3)
                ->where('status', 1)
                ->whereNotNull('surat_penawaran_harga_id')
                ->count('surat_penawaran_harga_id');

        return view('livewire.dashboard.chart-sph', [
            'labels' => ['Belum disetujui Manajer', 'Tolak manajer', 'Belum disetujui Direktur', 'Tolak direktur', 'Disetujui direktur'],
            'values' => [$sph_belum_disetujui_manajer, $sph_ditolak_manajer, $sph_sudah_disetujui_manajer, $sph_ditolak_direktur, $sph_sudah_disetujui_direktur],
        ]);
    }
}
