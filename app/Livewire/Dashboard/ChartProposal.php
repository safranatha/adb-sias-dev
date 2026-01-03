<?php

namespace App\Livewire\Dashboard;

use App\Models\DocumentApprovalWorkflow;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ChartProposal extends Component
{
    public function render()
    {
        $proposal_belum_disetujui_manajer = DocumentApprovalWorkflow::whereNull('status')->where('level', '=', 0)->whereNotNull('proposal_id')->count();

        $proposal_ditolak_manajer =
            DocumentApprovalWorkflow::where('level', 2)
                ->where('status', 0)
                ->whereNotNull('proposal_id')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('document_approval_workflow as daw2')
                        ->whereColumn('daw2.proposal_id', 'document_approval_workflow.proposal_id')
                        ->whereColumn('daw2.id', '>', 'document_approval_workflow.id');
                })
                ->count();

        $proposal_sudah_disetujui_manajer =
            DocumentApprovalWorkflow::where('level', 2)
                ->where('status', 1)
                ->whereNotNull('proposal_id')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('document_approval_workflow as daw2')
                        ->whereColumn('daw2.proposal_id', 'document_approval_workflow.proposal_id')
                        ->whereColumn('daw2.id', '>', 'document_approval_workflow.id')
                        ->where('daw2.level', 3);
                    // ->where('daw2.status', 0);
                })
                ->count('proposal_id');

        $proposal_ditolak_direktur =
            DocumentApprovalWorkflow::where('level', 3)
                ->where('status', 0)
                ->whereNotNull('proposal_id')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('document_approval_workflow as daw2')
                        ->whereColumn('daw2.proposal_id', 'document_approval_workflow.proposal_id')
                        ->whereColumn('daw2.id', '>', 'document_approval_workflow.id');
                })
                ->count();

        $proposal_sudah_disetujui_direktur =
            DocumentApprovalWorkflow::where('level', 3)
                ->where('status', 1)
                ->whereNotNull('proposal_id')
                ->count('proposal_id');

        return view('livewire.dashboard.chart-proposal', [
            'labels' => ['Belum disetujui Manajer', 'Tolak manajer', 'Belum disetujui Direktur', 'Tolak direktur', 'Disetujui direktur'],
            'values' => [$proposal_belum_disetujui_manajer, $proposal_ditolak_manajer, $proposal_sudah_disetujui_manajer, $proposal_ditolak_direktur, $proposal_sudah_disetujui_direktur],
        ]);
    }
}
