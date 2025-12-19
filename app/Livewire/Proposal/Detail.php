<?php

namespace App\Livewire\Proposal;

use App\Models\DocumentApprovalWorkflow;
use App\Models\Proposal;
use Livewire\Component;

class Detail extends Component
{
    public $proposal_id; // wajib ada


    public function mount($id)
    {
        $this->proposal_id = $id;
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
