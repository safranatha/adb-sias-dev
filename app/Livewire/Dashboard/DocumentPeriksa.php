<?php

namespace App\Livewire\Dashboard;

use App\Models\DocumentApprovalWorkflow;
use App\Models\Proposal;
use App\Models\Tender;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class DocumentPeriksa extends Component
{
    public function render()
    {
        $proposal_periksa=DocumentApprovalWorkflow::with(['proposal'])
                ->whereNotNull('proposal_id')
                ->whereNull('status')
                ->select('document_approval_workflow.*')
                ->orderBy('created_at', 'desc')->count();

        $sph_periksa=DocumentApprovalWorkflow::with(['surat_penawaran_harga'])
                ->whereNotNull('surat_penawaran_harga_id')
                ->whereNull('status')
                ->select('document_approval_workflow.*')
                ->orderBy('created_at', 'desc')->count();
        $tender_dalam_proses=Tender::where('status','=','Dalam Proses')->count();
        return view('livewire.dashboard.document-periksa',[
            'proposal_periksa'=>$proposal_periksa,
            'sph_periksa'=>$sph_periksa,
            'tender_dalam_proses'=>$tender_dalam_proses
        ]);
    }
}
