<?php

namespace App\Livewire\Proposal;

use App\Helpers\DokumenTenderHelper;
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
        return DokumenTenderHelper::downloadHelper(Proposal::class, $id, 'file_path_proposal', 'File Proposal');
    }

    public function render()
    {
        // dd(Proposal::all());
        return view('livewire.proposal.index', [
            'proposals' => Proposal::whereHas('document_approval_workflows', function ($query) {
                $query->where('status','!=', null);
            })
                ->orderBy('created_at', 'desc')
                ->paginate(5),

        ])->title('Proposal');
    }
}
