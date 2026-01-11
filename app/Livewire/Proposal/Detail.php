<?php

namespace App\Livewire\Proposal;

use App\Helpers\DokumenTenderHelper;
use App\Models\DocumentApprovalWorkflow;
use Livewire\Component;

class Detail extends Component
{
    public $proposal_id; // wajib ada


    public function mount($id)
    {
        $this->proposal_id = $id;
    }

    public function download($id)
    {
        return DokumenTenderHelper::downloadHelper(DocumentApprovalWorkflow::class, $id, 'file_path_revisi', 'File revisi');
    }


    public function render()
    {
        return view('livewire.proposal.detail', [
            'document_approvals' => DocumentApprovalWorkflow::with(['proposal'])
                ->where('proposal_id', $this->proposal_id)
                ->whereNotNull('status')
                ->orderByDesc('created_at')
                ->get()
                
        ]);
    }
}
