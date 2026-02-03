<?php

namespace App\Livewire\Proposal;

use App\Services\Tender\ApprovalTenderDocService;
use App\Helpers\DokumenTenderHelper;
use App\Models\Proposal;
use App\Models\DocumentApprovalWorkflow;
use App\Models\Tender;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Services\SendTelegram\Tender\Proposal\ReviseProposalTele;


class Active extends Component
{
    use WithFileUploads, WithPagination;

    public $tender_id;
    public $nama_proposal;
    public $file_path_proposal;
    public $proposal_id;
    public $isEditing = false;

    public $pesan_revisi;

    public $file_path_revisi;

    protected $rules = [
        'tender_id' => ['required', 'exists:tenders,id'],
        'nama_proposal' => ['required', 'string', 'max:255'],
        'file_path_proposal' => ['required', 'file', 'max:10240'],
    ];

    protected ApprovalTenderDocService $approvalTenderDocService;

    public function boot(ApprovalTenderDocService $approvalTenderDocService, ReviseProposalTele $reviseProposalTele)
    {
        $this->approvalTenderDocService = $approvalTenderDocService;
        $this->reviseProposalTele = $reviseProposalTele;
    }

    public function mount()
    {
        // Reset properties
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->tender_id = '';
        $this->nama_proposal = '';
        $this->file_path_proposal = '';
        $this->isEditing = false;
        $this->proposal_id = null;
        $this->pesan_revisi = '';

    }


    public function edit($id)
    {
        $proposal = Proposal::findOrFail($id);
        // update kolom waktu dibaca sehingga manajer tau apakah proposal sudah dibaca
        $this->storeWaktuDibaca($id);
        $this->tender_id = $proposal->tender_id;
        $this->nama_proposal = $proposal->nama_proposal;
        $this->file_path_proposal = $proposal->file_path_proposal;
        $this->isEditing = true;
        $this->proposal_id = $id;
    }


    public function storeWaktuDibaca($id)
    {
        return DokumenTenderHelper::storeWaktuDibaca($id, DocumentApprovalWorkflow::class, 'proposal_id');
    }


    public function download($id)
    {
        return DokumenTenderHelper::downloadHelper(Proposal::class, $id, 'file_path_proposal', 'File Proposal');
    }

    public function downloadFileRevisi($id)
    {
        return DokumenTenderHelper::downloadRevisionHelper(DocumentApprovalWorkflow::class, $id, 'file_path_revisi', 'File revisi proposal', 'proposal_id');
    }

    public function update()
    {
        // Validasi hanya field yang diisi
        $rules = [];
        if ($this->nama_proposal) {
            $rules['nama_proposal'] = ['required', 'string', 'max:255'];
        }
        if ($this->file_path_proposal instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $rules['file_path_proposal'] = ['file', 'max:10240'];
        }

        if (!empty($rules)) {
            $this->validate($rules);
        }

        $proposal = Proposal::findOrFail($this->proposal_id);

        if ($this->nama_proposal) {
            $proposal->update([
                'nama_proposal' => $this->nama_proposal,
            ]);
        }

        if ($this->file_path_proposal instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            // Hapus file lama jika ada
            if ($proposal->file_path_proposal && file_exists(public_path('storage/' . $proposal->file_path_proposal))) {
                unlink(public_path('storage/' . $proposal->file_path_proposal));
            }

            $path = DokumenTenderHelper::storeRevisionFileOnStroage($this->file_path_proposal, 'proposals');

            // store ke db
            $proposal->update([
                'file_path_proposal' => $path,
            ]);

            // create status on document approval workflow
            DocumentApprovalWorkflow::create([
                'user_id' => auth()->user()->id,
                'proposal_id' => $this->proposal_id,
                'keterangan' => "Proposal belum diperiksa oleh Manajer Teknik",
                'level' => 0,
            ]);

            $nama_tender= $proposal->tender()->where('id', $proposal->tender_id)->value('nama_tender');

            $this->reviseProposalTele->sendMessageToManajer("Proposal {$nama_tender} telah direvisi 🚀");

        }

        session()->flash('success', 'Proposal berhasil diupdate!');
        $this->dispatch('modal-closed', id: $this->proposal_id);
        $this->resetForm();
    }


    public function approve($id)
    {

        $approve = $this->approvalTenderDocService->approveDocumentProposal(DocumentApprovalWorkflow::class, $id, auth()->user()->roles->first()->name);

        if (!$approve) {
            session()->flash('error', 'Proses approval proposal gagal!');
            return;
        }

        session()->flash('success', 'Proposal berhasil di approve!');

    }

    public function reject($id)
    {
        // check role of user
        $nama_role = auth()->user()->roles->first()->name;

        $rules = [
            'pesan_revisi' => ['nullable', 'string', 'max:255'],
            'file_path_revisi' => ['required', 'file', 'max:10240']
        ];

        $this->validate($rules);

        // call helper for upload file revisi
        $path = DokumenTenderHelper::storeFileOnStroage($this->file_path_revisi, 'Document Tender Approval/Revisi Proposal');

        // panggil helper untuk reject document proposal
        $documentApproval = $this->approvalTenderDocService->rejectDocumentProposal(DocumentApprovalWorkflow::class, $id, $nama_role, $this->pesan_revisi, $path);

        if (!$documentApproval) {
            session()->flash('error', 'Proses approval proposal gagal!');
            return;
        }


        session()->flash('success', 'Proposal berhasil di tolak!');

    }

    public function render()
    {
        return view('livewire.proposal.active', [
            //mengambil data proposal yang aktif, dinilai dari status proposal, diambil yang bukan 1D 
            'proposals_active' => Proposal::with(['tender', 'user', 'document_approval_workflows'])
                ->where('user_id', '=', auth()->user()->id)
                ->whereDoesntHave('document_approval_workflows', function ($query) {
                    $query->where('status', 1)
                        ->whereColumn(
                            'document_approval_workflow.id',
                            '=',
                            DB::raw('(SELECT MAX(id) FROM document_approval_workflow WHERE proposal_id = proposals.id)')
                        );
                })
                ->select('proposals.*')
                ->orderBy('created_at', 'desc')
                ->paginate(5),

            // ambil data documen approval yang berelasi dengan proposal (proposal id not null)
            'document_approvals' => DocumentApprovalWorkflow::with(['proposal'])
                ->whereNotNull('proposal_id')
                ->whereNull('status')
                ->select('document_approval_workflow.*')
                ->orderBy('created_at', 'desc')
                ->paginate(5),

        ])->title('Proposal Active');
    }
}
