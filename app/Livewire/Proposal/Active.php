<?php

namespace App\Livewire\Proposal;

use App\Helpers\DokumenTenderHelper;
use App\Models\Proposal;
use App\Models\DocumentApprovalWorkflow;
use App\Models\Tender;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class Active extends Component
{
    use WithFileUploads, WithPagination;

    public $tender_id;
    public $nama_proposal;
    public $file_path_proposal;
    public $proposal_id;
    public $isEditing = false;

    public $pesan_revisi;

    protected $rules = [
        'tender_id' => ['required', 'exists:tenders,id'],
        'nama_proposal' => ['required', 'string', 'max:255'],
        'file_path_proposal' => ['required', 'file', 'mimes:pdf', 'max:10240'],
    ];

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
        $workflow = DocumentApprovalWorkflow::where('proposal_id', $id)
            ->whereNull('waktu_pesan_dibaca')
            ->latest('created_at') // atau latest() saja, default ke created_at
            ->first();

        if ($workflow) {
            $workflow->update([
                'waktu_pesan_dibaca' => now(),
            ]);
        }
    }


    public function download($id)
    {
        return DokumenTenderHelper::downloadHelper(Proposal::class, $id, 'file_path_proposal', 'File Proposal');
    }

    public function update()
    {
        // Validasi hanya field yang diisi
        $rules = [];
        if ($this->nama_proposal) {
            $rules['nama_proposal'] = ['required', 'string', 'max:255'];
        }
        if ($this->file_path_proposal instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $rules['file_path_proposal'] = ['file', 'mimes:pdf', 'max:10240'];
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

            $path=DokumenTenderHelper::storeRevisionFileOnStroage($this->file_path_proposal, 'proposals');

            // $original = $this->file_path_proposal->getClientOriginalName();
            // $timestamp = time();
            // $format_timestamp = date('g i a,d-m-Y', $timestamp);
            // $filename = "Revision" . "_" . $format_timestamp . "_" . $original;

            // // store ke storage
            // $path = $this->file_path_proposal->storeAs('proposals', $filename, 'public');

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
        }

        session()->flash('success', 'Proposal berhasil diupdate!');
        $this->dispatch('modal-closed', id: $this->proposal_id);
        $this->resetForm();
    }


    public function approve($id)
    {

        // check role of user
        $nama_role = auth()->user()->roles->first()->name;

        // Cari document approval berdasarkan proposal_id
        $documentApproval = DocumentApprovalWorkflow::where('proposal_id', $id)
            ->latest() // Ambil yang terbaru
            ->first();

        $documentApproval->update([
            'user_id' => auth()->user()->id,
            'status' => true,
            'level' => ($nama_role == "Manajer Teknik") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'keterangan' => ($nama_role == "Manajer Teknik") ? "Proposal disetujui oleh Manajer Teknik" : ($nama_role == "Direktur" ? "Proposal disetujui oleh Direktur" : null),
        ]);

        session()->flash('success', 'Proposal berhasil di approve!');

    }

    public function reject($id)
    {
        // check role of user
        $nama_role = auth()->user()->roles->first()->name;

        $rules = ['pesan_revisi' => ['required', 'string', 'max:255']];

        $this->validate($rules);


        // Cari document approval berdasarkan proposal_id
        $documentApproval = DocumentApprovalWorkflow::where('proposal_id', $id)
            ->latest() // Ambil yang terbaru
            ->first();

        $documentApproval->update([
            'user_id' => auth()->user()->id,
            'status' => false,
            'level' => ($nama_role == "Manajer Teknik") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'keterangan' => ($nama_role == "Manajer Teknik") ? "Proposal ditolak oleh Manajer Teknik" : ($nama_role == "Direktur" ? "Proposal ditolak oleh Direktur" : null),
            'pesan_revisi' => $this->pesan_revisi
        ]);


        session()->flash('success', 'Proposal berhasil di tolak!');

    }

    public function render()
    {
        return view('livewire.proposal.active', [
            //mengambil data proposal yang aktif, dinilai dari status proposal, diambil yang bukan 1D 
            'proposals_active' => Proposal::with(['tender', 'user', 'document_approval_workflows'])
                ->whereDoesntHave('document_approval_workflows', function ($query) {
                    $query->where('status', 1);
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
