<?php

namespace App\Livewire\Tender;

use App\Services\Tender\ApprovalTenderDocServiceDirektur;
use App\Helpers\DokumenTenderHelper;
use App\Models\DocumentApprovalWorkflow;
use App\Models\Proposal;
use App\Models\SuratPenawaranHarga;
use App\Models\Tender;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

class Detail extends Component
{
    use WithFileUploads;

    public $tender_id; // wajib ada
    public $pesan_revisi;
    public $file_path_revisi;
    public $status;

    protected ApprovalTenderDocServiceDirektur $approvalTenderDocServiceDirektur;

    public function boot(ApprovalTenderDocServiceDirektur $approvalTenderDocServiceDirektur)
    {
        $this->approvalTenderDocServiceDirektur = $approvalTenderDocServiceDirektur;
    }

    public function mount($id)
    {
        $this->tender_id = $id;
    }

    public function get_data_proposal($id)
    {
        $proposal = Proposal::where('tender_id', $id)->first();

        if ($proposal == null) {
            return session()->flash('error', 'Proposal tidak ditemukan.');
        }

        $is_approved = DocumentApprovalWorkflow::where('proposal_id', $proposal->id)
            ->where('status', 1)
            ->where('level', 2)
            ->exists();

        if ($is_approved == false) {
            return session()->flash('error', 'Proposal belum disetujui oleh Manajer Teknik.');
        }

        $file = public_path('storage/' . $proposal->file_path_proposal);

        if (!file_exists($file)) {
            return session()->flash('error', 'File Proposal tidak ditemukan di storage.');
        }

        return response()->download($file);

    }


    public function get_data_SPH($id)
    {
        $sph = SuratPenawaranHarga::where('tender_id', $id)->first();

        if ($sph == null) {
            return session()->flash('error', 'Surat Penawaran Harga tidak ditemukan.');
        }

        $is_approved = DocumentApprovalWorkflow::where('surat_penawaran_harga_id', $sph->id)
            ->where('status', 1)
            ->where('level', 2)
            ->exists();

        if ($is_approved == false) {
            return session()->flash('error', 'Surat Penawaran Harga belum disetujui oleh Manajer Teknik.');
        }


        $file = public_path('storage/' . $sph->file_path_sph);

        if (!file_exists($file)) {
            return session()->flash('error', 'File Surat Penawaran Harga tidak ditemukan di storage.');
        }

        return response()->download($file);

    }

    public function editStatus($id)
    {
        $tender = Tender::findOrFail($id);

        $this->tender_id = $tender->id;
        $this->status = $tender->status; // ⬅️ INI KUNCI
    }

    public function update_status_tender()
    {
        Tender::where('id', $this->tender_id)
            ->update([
                'status' => $this->status
            ]);

        session()->flash('success', 'Status tender berhasil diperbarui');

        $this->dispatch('modal-close', name: 'edit-status-tender');

        $this->dispatch('modal-close', name: 'confirm-edit-status-tender');
    }



    public function approve_proposal($id)
    {
        $approve = $this->approvalTenderDocServiceDirektur->approveDocumentProposal(DocumentApprovalWorkflow::class, $id, auth()->user()->roles->first()->name);

        if (!$approve) {
            session()->flash('error', 'Proses approval proposal gagal!');
            return;
        }

        session()->flash('success', 'Proposal berhasil di approve!');
    }

    public function reject_proposal($id)
    {
        // check role of user
        $nama_role = auth()->user()->roles->first()->name;

        $rules = [
            'pesan_revisi' => ['required', 'string', 'max:255'],
            'file_path_revisi' => ['nullable', 'file', 'max:10240']
        ];

        $this->validate($rules);

        // set path to null

        $path = "";

        if ($this->file_path_revisi) {

            // call helper for upload file revisi
            $path = DokumenTenderHelper::storeFileOnStroage($this->file_path_revisi, 'Document Tender Approval/Revisi Proposal');

        }

        // panggil helper untuk reject document proposal
        $documentApproval = $this->approvalTenderDocServiceDirektur->rejectDocumentProposal(DocumentApprovalWorkflow::class, $id, $nama_role, $this->pesan_revisi, $path);

        if (!$documentApproval) {
            session()->flash('error', 'Proses approval proposal gagal!');
            return;
        }

        $this->reset(['pesan_revisi', 'file_path_revisi']);

        session()->flash('success', 'Proposal berhasil di tolak!');
    }

    public function approve_sph($id)
    {
        // check role of user
        $nama_role = auth()->user()->roles->first()->name;

        $approve = $this->approvalTenderDocServiceDirektur->approveDocumentSPH(DocumentApprovalWorkflow::class, $id, $nama_role);

        if (!$approve) {
            session()->flash('error', 'Proses approval proposal gagal!');
            return;
        }

        session()->flash('success', 'Surat Penawaran Harga berhasil di approve!');
    }

    public function reject_sph($id)
    {
        // check role of user
        $nama_role = auth()->user()->roles->first()->name;

        $rules = [
            'pesan_revisi' => ['required', 'string', 'max:255'],
            'file_path_revisi' => ['nullable', 'file', 'max:10240']
        ];

        $this->validate($rules);

        $path = "";

        if ($this->file_path_revisi) {
            // call helper for upload file revisi
            $path = DokumenTenderHelper::storeFileOnStroage($this->file_path_revisi, 'Document Tender Approval/Revisi SPH');
        }

        $documentApproval = $this->approvalTenderDocServiceDirektur->rejectDocumentSPH(DocumentApprovalWorkflow::class, $id, $nama_role, $this->pesan_revisi, $path);

        if (!$documentApproval) {
            session()->flash('error', 'Proses approval proposal gagal!');
            return;
        }

        $this->reset(['pesan_revisi', 'file_path_revisi']);

        session()->flash('success', 'Surat Penawaran Harga berhasil di tolak!');
    }


    public function render()
    {
        // $proposal_id = Proposal::where('tender_id', $selected_tender_id)->pluck('id');
        return view('livewire.tender.detail', ['tender' => Tender::find($this->tender_id)])->title('Detail Tender');
    }
}
