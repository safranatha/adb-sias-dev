<?php

namespace App\Livewire\Tender;

use App\Models\DocumentApprovalWorkflow;
use App\Models\Proposal;
use App\Models\SuratPenawaranHarga;
use App\Models\Tender;
use Livewire\Component;

class Detail extends Component
{

    public $tender_id; // wajib ada
    public $pesan_revisi;

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

    public function approve($id)
    {

        // check role of user
        $nama_role = auth()->user()->roles->first()->name;

        // // Cari document approval berdasarkan surat_penawaran_harga_id
        // $documentApproval = DocumentApprovalWorkflow::where('surat_penawaran_harga_id', $id)
        //     ->latest() // Ambil yang terbaru
        //     ->first();

        $proposal_id = Proposal::where('tender_id', $id)->pluck('id')->first();

        $sph_id = SuratPenawaranHarga::where('tender_id', $id)->pluck('id')->first();


        DocumentApprovalWorkflow::create([
            'user_id' => auth()->user()->id,
            'status' => true,
            'proposal_id' => $proposal_id,
            'surat_penawaran_harga_id' => $sph_id,
            'level' => ($nama_role == "Manajer Admin") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'keterangan' => ($nama_role == "Manajer Admin") ? "Berkas Tender disetujui oleh Manajer Admin" : ($nama_role == "Direktur" ? "Berkas Tender disetujui oleh Direktur" : null),
        ]);

        session()->flash('success', 'Berkas Tender berhasil di approve!');

    }

    public function reject($id)
    {
        // check role of user
        $nama_role = auth()->user()->roles->first()->name;

        $rules = ['pesan_revisi' => ['required', 'string', 'max:255']];

        $this->validate($rules);

         $proposal_id = Proposal::where('tender_id', $id)->pluck('id')->first();

        $sph_id = SuratPenawaranHarga::where('tender_id', $id)->pluck('id')->first();


        DocumentApprovalWorkflow::create([
            'user_id' => auth()->user()->id,
            'status' => false,
            'proposal_id' => $proposal_id,
            'surat_penawaran_harga_id' => $sph_id,
            'level' => ($nama_role == "Manajer Admin") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'keterangan' => ($nama_role == "Manajer Admin") ? "Berkas Tender ditolak oleh Manajer Admin" : ($nama_role == "Direktur" ? "Berkas Tender ditolak oleh Direktur" : null),
            'pesan_revisi' => $this->pesan_revisi
        ]);

        session()->flash('success', 'Berkas Tender berhasil ditolak!');
    }


    public function render()
    {
        // $proposal_id = Proposal::where('tender_id', $selected_tender_id)->pluck('id');
        return view('livewire.tender.detail', ['tender' => Tender::find($this->tender_id)]);
    }
}
