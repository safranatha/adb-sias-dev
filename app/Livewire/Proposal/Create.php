<?php

namespace App\Livewire\Proposal;

use App\Helpers\DokumenTenderHelper;
use App\Models\DocumentApprovalWorkflow;
use App\Models\Proposal;
use App\Models\Tender;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\apiWa\ApiWa;
use Livewire\Attributes\Title;

class Create extends Component
{
    use WithFileUploads;

    public $tender_id;
    public $nama_proposal;
    public $file_path_proposal;

    protected $rules = [
        'tender_id' => ['required', 'exists:tenders,id'],
        'nama_proposal' => ['required', 'string', 'max:255'],
        'file_path_proposal' => ['required', 'file', 'mimes:pdf', 'max:10240'],
    ];

    protected ApiWa $apiWa;

    public function boot(ApiWa $apiWa)
    {
        $this->apiWa = $apiWa;
    }

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->tender_id = '';
        $this->nama_proposal = '';
        $this->file_path_proposal = '';
    }

    public function store()
    {
        $this->validate();

        $path=DokumenTenderHelper::storeFileOnStroage($this->file_path_proposal, 'proposals');

        // Save to database
        $proposal = Proposal::create([
            'user_id' => auth()->user()->id,
            'tender_id' => $this->tender_id,
            'nama_proposal' => $this->nama_proposal,
            'file_path_proposal' => $path,
        ]);

        // Create status on document approval workflow
        DocumentApprovalWorkflow::create([
            'user_id' => auth()->user()->id,
            'proposal_id' => $proposal->id,
            'keterangan' => "Proposal belum diperiksa oleh Manajer Teknik",
            'level' => 0,
        ]);
        
        // send wa to manajer teknik
        // 0895396706912
        // 085967061693
        $this->apiWa->Kirimfonnte('62895396706912', 'Proposal dengan nama ' . $proposal->nama_proposal . ' telah diupload, silahkan diperiksa!');
        
        session()->flash('success', 'Proposal berhasil diupload!');
        $this->dispatch('modal-closed', id: 'store');
        $this->resetForm();


        return redirect()->route('proposal.active');
    }

    public function render()
    {
        return view('livewire.proposal.create', [
            'tender_status' => Tender::where('status', 'Dalam Proses')
                ->doesntHave('proposal')
                ->get(),
        ])->title('Buat Proposal Baru');
    }
}
