<?php
namespace App\Services\Tender;


use App\Models\DocumentApprovalWorkflow;
use Illuminate\Support\Facades\DB;

class DokumenChartService
{
    public function dokumenBelumDisetujuiManajer(
        string $dokumen_id
    ) {
        $count_doc_belum_disetujui = DocumentApprovalWorkflow::whereNull('status')->where('level', '=', 0)->whereNotNull($dokumen_id)->count();

        return $count_doc_belum_disetujui;
    }

    public function dokumenDitolakManajer(
        string $dokumen_id
    ) {
        // DocumentApprovalWorkflow::where('level', 2)
        //     ->where('status', 0)
        //     ->whereNotNull('surat_penawaran_harga_id')
        //     ->whereNotExists(function ($query) {
        //         $query->select(DB::raw(1))
        //             ->from('document_approval_workflow as daw2')
        //             ->whereColumn('daw2.surat_penawaran_harga_id', 'document_approval_workflow.surat_penawaran_harga_id')
        //             ->whereColumn('daw2.id', '>', 'document_approval_workflow.id');
        //     })
        //     ->count();
        $count_doc_ditolak = DocumentApprovalWorkflow::where('level', 2)
            ->where('status', 0)
            ->whereNotNull($dokumen_id)
            ->whereNotExists(function ($query) use ($dokumen_id) {
                $query->select(DB::raw(1))
                    ->from('document_approval_workflow as daw2')
                    ->whereColumn('daw2.' . $dokumen_id, 'document_approval_workflow.' . $dokumen_id)
                    ->whereColumn('daw2.id', '>', 'document_approval_workflow.id');
            })
            ->count();

        return $count_doc_ditolak;
    }

    public function dokumenSudahDisetujuiManajer(
        string $dokumen_id
    ) {
        // DocumentApprovalWorkflow::where('level', 2)
        //     ->where('status', 1)
        //     ->whereNotNull('proposal_id')
        //     ->whereNotExists(function ($query) {
        //         $query->select(DB::raw(1))
        //             ->from('document_approval_workflow as daw2')
        //             ->whereColumn('daw2.proposal_id', 'document_approval_workflow.proposal_id')
        //             ->whereColumn('daw2.id', '>', 'document_approval_workflow.id')
        //             ->where('daw2.level', 3);
        //         // ->where('daw2.status', 0);
        //     })
        //     ->count('proposal_id');
        $count_doc_sudah_disetujui = DocumentApprovalWorkflow::where('level', 2)
            ->where('status', 1)
            ->whereNotNull($dokumen_id)
            ->whereNotExists(function ($query) use ($dokumen_id) {
                $query->select(DB::raw(1))
                    ->from('document_approval_workflow as daw2')
                    ->whereColumn('daw2.' . $dokumen_id, 'document_approval_workflow.' . $dokumen_id)
                    ->whereColumn('daw2.id', '>', 'document_approval_workflow.id')
                    ->where('daw2.level', 3);
                // ->where('daw2.status', 0);
            })
            ->count($dokumen_id);

        return $count_doc_sudah_disetujui;
    }

    public function dokumenDitolakDirektur(
        string $dokumen_id
    ) {
        // DocumentApprovalWorkflow::where('level', 3)
        //         ->where('status', 0)
        //         ->whereNotNull('surat_penawaran_harga_id')
        //         ->whereNotExists(function ($query) {
        //             $query->select(DB::raw(1))
        //                 ->from('document_approval_workflow as daw2')
        //                 ->whereColumn('daw2.surat_penawaran_harga_id', 'document_approval_workflow.surat_penawaran_harga_id')
        //                 ->whereColumn('daw2.id', '>', 'document_approval_workflow.id');
        //         })
        //         ->count();
        $count_doc_ditolak = DocumentApprovalWorkflow::where('level', 3)
            ->where('status', 0)
            ->whereNotNull($dokumen_id)
            ->whereNotExists(function ($query) use ($dokumen_id) {
                $query->select(DB::raw(1))
                    ->from('document_approval_workflow as daw2')
                    ->whereColumn('daw2.' . $dokumen_id, 'document_approval_workflow.' . $dokumen_id)
                    ->whereColumn('daw2.id', '>', 'document_approval_workflow.id');
            })
            ->count();

        return $count_doc_ditolak;
    }

    public function dokumenSudahDisetujuiDirektur(
        string $dokumen_id
    ) {
        // DocumentApprovalWorkflow::where('level', 3)
        //         ->where('status', 1)
        //         ->whereNotNull('proposal_id')
        //         ->count('proposal_id');
        $count_doc_sudah_disetujui = DocumentApprovalWorkflow::where('level', 3)
            ->where('status', 1)
            ->whereNotNull($dokumen_id)
            ->count($dokumen_id);

        return $count_doc_sudah_disetujui;
    }
}