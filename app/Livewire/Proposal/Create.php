<?php

namespace App\Livewire\Proposal;

use App\Helpers\DokumenTenderHelper;
use App\Models\DocumentApprovalWorkflow;
use App\Models\Proposal;
use App\Models\Tender;
use App\Models\User;
use Http;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use App\Services\SendTelegram\Tender\Proposal\CreateProposalTele;

class Create extends Component
{
    use WithFileUploads;

    public $tender_id;
    public $nama_proposal;
    public $file_path_proposal;

    protected $rules = [
        'tender_id' => ['required', 'exists:tenders,id'],
        'nama_proposal' => ['required', 'string', 'max:255'],
        'file_path_proposal' => ['required', 'file', 'max:10240'],
    ];

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

    public function store(CreateProposalTele $telegram)
    {
        $this->validate();

        $path = DokumenTenderHelper::storeFileOnStroage($this->file_path_proposal, 'proposals');

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

        session()->flash('success', 'Proposal berhasil diupload!');
        $this->dispatch('modal-closed', id: 'store');
        $this->resetForm();

        $telegram->sendMessageToManajer(
            "Proposal " . $proposal->nama_proposal . " telah dibuat 🚀"
        );



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
