<?php

namespace App\Livewire\Proposal;

use App\Models\DocumentApprovalWorkflow;
use App\Models\Proposal;
use App\Models\Tender;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function download($id)
    {
        $proposal = Proposal::findOrFail($id);

        if (!$proposal) {
            return session()->flash('error', 'Proposal tidak ditemukan.');
        }

        $file_path = public_path('storage/' . $proposal->file_path_proposal);

        if (!file_exists($file_path)) {
            return session()->flash('error', 'File Proposal tidak ditemukan di storage.');
        }

        return response()->download($file_path);
    }

    public function render()
    {
        // dd(Proposal::all());
        return view('livewire.proposal.index', [
            'proposals' => Proposal::with(['tender', 'user', 'document_approval_workflows'])
                ->select('proposals.*')
                ->selectRaw("
                        EXISTS (
                            SELECT 1 
                            FROM document_approval_workflow daw 
                            WHERE daw.proposal_id = proposals.id
                            AND daw.level IS NOT NULL
                        ) AS is_approved
                    ")
                ->orderBy('created_at', 'desc')
                ->paginate(5),

            'document_approvals' => DocumentApprovalWorkflow::with(['proposal'])
                ->whereNotNull('proposal_id')
                ->whereNotNull('status')
                ->select('document_approval_workflow.*')
                ->orderBy('created_at', 'desc')
                ->paginate(5),

            'tender_status' => Tender::where('status', 'Dalam Proses')
                ->doesntHave('proposal')
                ->get(),

        ])->title('Proposal');
    }
}
