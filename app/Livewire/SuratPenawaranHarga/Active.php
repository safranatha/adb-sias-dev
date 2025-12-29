<?php

namespace App\Livewire\SuratPenawaranHarga;

use App\Helpers\DokumenTenderHelper;
use App\Helpers\DownloadHelper;
use App\Models\DocumentApprovalWorkflow;
use App\Models\SuratPenawaranHarga;
use App\Models\Tender;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class Active extends Component
{
    use WithPagination, WithFileUploads;

    public $tender_id;
    public $nama_sph;
    public $file_path_sph;
    public $sph_id;
    public $isEditing = false;

    public $pesan_revisi;

    protected $rules = [
        'tender_id' => ['required', 'exists:tenders,id'],
        'nama_sph' => ['required', 'string', 'max:255'],
        'file_path_sph' => ['required', 'file', 'mimes:pdf', 'max:10240'],
    ];

    public function mount()
    {
        // Reset properties
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->tender_id = '';
        $this->nama_sph = '';
        $this->file_path_sph = '';
        $this->isEditing = false;
        $this->sph_id = null;
    }


    public function edit($id)
    {
        $sph = SuratPenawaranHarga::findOrFail($id);
        $this->storeWaktuDibaca($id);
        $this->tender_id = $sph->tender_id;
        $this->nama_sph = $sph->nama_sph;
        $this->file_path_sph = $sph->file_path_sph;
        $this->pesan_revisi = $sph->pesan_revisi;
        $this->isEditing = true;
        $this->sph_id = $id;
    }

    public function storeWaktuDibaca($id)
    {
        $workflow = DocumentApprovalWorkflow::where('surat_penawaran_harga_id', $id)
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
        return DokumenTenderHelper::downloadHelper(SuratPenawaranHarga::class, $id, 'file_path_sph', 'Surat Penawaran Harga');
    }

    public function update()
    {
        // Validasi hanya field yang diisi
        $rules = [];
        if ($this->nama_sph) {
            $rules['nama_sph'] = ['required', 'string', 'max:255'];
        }
        if ($this->file_path_sph instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $rules['file_path_sph'] = ['file', 'mimes:pdf', 'max:10240'];
        }

        if (!empty($rules)) {
            $this->validate($rules);
        }

        $sph = SuratPenawaranHarga::findOrFail($this->sph_id);

        if ($this->nama_sph) {
            $sph->update([
                'nama_sph' => $this->nama_sph,
            ]);
        }

        if ($this->file_path_sph instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            // Hapus file lama jika ada
            if ($sph->file_path_sph && file_exists(public_path('storage/' . $sph->file_path_sph))) {
                unlink(public_path('storage/' . $sph->file_path_sph));
            }

            $path = DokumenTenderHelper::storeRevisionFileOnStroage($this->file_path_sph, 'surat_penawaran_hargas');


            $sph->update([
                'file_path_sph' => $path,
            ]);

            // create status on document approval workflow
            DocumentApprovalWorkflow::create([
                'user_id' => auth()->user()->id,
                'surat_penawaran_harga_id' => $this->sph_id,
                'keterangan' => "Surat Penawaran Harga belum diperiksa oleh Manajer Admin",
                'level' => 0,
            ]);
        }

        session()->flash('success', 'Surat Penawaran Harga berhasil diupdate!.');
        $this->dispatch('modal-closed', id: $this->sph_id);

        $this->resetForm();
    }


    public function approve($id)
    {

        // check role of user
        $nama_role = auth()->user()->roles->first()->name;

        // Cari document approval berdasarkan surat_penawaran_harga_id
        $documentApproval = DocumentApprovalWorkflow::where('surat_penawaran_harga_id', $id)
            ->latest() // Ambil yang terbaru
            ->first();

        $documentApproval->update([
            'user_id' => auth()->user()->id,
            'status' => true,
            'level' => ($nama_role == "Manajer Admin") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'keterangan' => ($nama_role == "Manajer Admin") ? "Surat Penawaran Harga disetujui oleh Manajer Admin" : ($nama_role == "Direktur" ? "Surat Penawaran Harga disetujui oleh Direktur" : null),
        ]);

        session()->flash('success', 'Surat Penawaran Harga berhasil di approve!');

    }

    public function reject($id)
    {
        // check role of user
        $nama_role = auth()->user()->roles->first()->name;

        $rules = ['pesan_revisi' => ['required', 'string', 'max:255']];

        $this->validate($rules);

        // Cari document approval berdasarkan surat_penawaran_harga_id
        $documentApproval = DocumentApprovalWorkflow::where('surat_penawaran_harga_id', $id)
            ->latest() // Ambil yang terbaru
            ->first();

        $documentApproval->update([
            'user_id' => auth()->user()->id,
            'status' => false,
            'level' => ($nama_role == "Manajer Admin") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'pesan_revisi' => $this->pesan_revisi,
            'keterangan' => ($nama_role == "Manajer Admin") ? "Surat Penawaran Harga ditolak oleh Manajer Admin" : ($nama_role == "Direktur" ? "Surat Penawaran Harga ditolak oleh Direktur" : null),
        ]);

        session()->flash('success', 'Surat Penawaran Harga berhasil di tolak!');

    }

    public function render()
    {
        return view('livewire.surat-penawaran-harga.active', [
            'sphs' => SuratPenawaranHarga::with(['tender', 'user', 'document_approval_workflows'])
                ->whereDoesntHave('document_approval_workflows', function ($query) {
                    $query->where('status', 1);
                })
                ->select('surat_penawaran_hargas.*')
                ->orderBy('created_at', 'desc')
                ->paginate(5),

            'document_approvals' => DocumentApprovalWorkflow::with(['surat_penawaran_harga'])
                ->whereNotNull('surat_penawaran_harga_id')
                ->whereNull('status')
                ->select('document_approval_workflow.*')
                ->orderBy('created_at', 'desc')
                ->paginate(5),

        ])->title('Surat Penawaran Harga');
    }
}
