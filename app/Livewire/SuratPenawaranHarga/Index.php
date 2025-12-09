<?php

namespace App\Livewire\SuratPenawaranHarga;

use App\Models\DocumentApprovalWorkflow;
use App\Models\SuratPenawaranHarga;
use App\Models\Tender;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'tailwind';

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
        $this->tender_id = $sph->tender_id;
        $this->nama_sph = $sph->nama_sph;
        $this->file_path_sph = $sph->file_path_sph;
        $this->isEditing = true;
        $this->sph_id = $id;
    }

    public function download($id)
    {
        $sph = SuratPenawaranHarga::findOrFail($id);

        if (!$sph) {
            return session()->flash('error', 'Surat Penawaran Harga tidak ditemukan.');
        }

        $file_path = public_path('storage/' . $sph->file_path_sph);

        if (!file_exists($file_path)) {
            return session()->flash('error', 'File Surat Penawaran Harga tidak ditemukan di storage.');
        }

        return response()->download($file_path);
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

            $original = $this->file_path_sph->getClientOriginalName();

            $timestamp = time();
            $format_timestamp = date('g i a,d-m-Y', $timestamp);
            $filename = "Revision" . "_" . $format_timestamp . "_" . $original;

            // store to laravel storage
            $path = $this->file_path_sph->storeAs('surat_penawaran_hargas', $filename, 'public');

            $sph->update([
                'file_path_sph' => $path,
            ]);
        }

        session()->flash('success', 'Surat Penawaran Harga berhasil diupdate!.');
        $this->dispatch('modal-closed', id: $this->sph_id);

        $this->resetForm();
    }

    public function store()
    {
        $this->validate();

        // save to laravel storage
        $original = $this->file_path_sph->getClientOriginalName();
        $timestamp = time();
        $format_timestamp = date('g i a,d-m-Y', $timestamp);
        $filename = "New" . "_" . $format_timestamp . "_" . $original;
        // store to laravel storage
        $path = $this->file_path_sph->storeAs('surat_penawaran_hargas', $filename, 'public');

        // save to database
        SuratPenawaranHarga::create([
            'user_id' => auth()->user()->id,
            'tender_id' => $this->tender_id,
            'nama_sph' => $this->nama_sph,
            'file_path_sph' => $path,
        ]);

        session()->flash('success', 'Surat Penawaran Harga berhasil diupload!');

        $this->dispatch('modal-closed', id: 'store');

        $this->resetForm();

    }

    public function approve($id)
    {

        // check role of user
        $nama_role = auth()->user()->roles->first()->name;

        DocumentApprovalWorkflow::create([
            'user_id' => auth()->user()->id,
            'surat_penawaran_harga_id' => $id,
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

        DocumentApprovalWorkflow::create([
            'user_id' => auth()->user()->id,
            'surat_penawaran_harga_id' => $id,
            'status' => false,
            'level' => ($nama_role == "Manajer Admin") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'keterangan' => ($nama_role == "Manajer Admin") ? "Surat Penawaran Harga ditolak oleh Manajer Admin" : ($nama_role == "Direktur" ? "Surat Penawaran Harga ditolak oleh Direktur" : null),
            'pesan_revisi' => $this->pesan_revisi

        ]);

        session()->flash('success', 'Surat Penawaran Harga berhasil di tolak!');

    }

    public function render()
    {
        return view('livewire.surat-penawaran-harga.index', [
            'sphs' => SuratPenawaranHarga::with(['tender', 'user','document_approval_workflows'])
                ->select('surat_penawaran_hargas.*')
                ->selectRaw("
                        EXISTS (
                            SELECT 1 
                            FROM document_approval_workflow daw 
                            WHERE daw.surat_penawaran_harga_id = surat_penawaran_hargas.id
                            AND daw.level IS NOT NULL
                        ) AS is_approved
                    ")
                ->orderBy('created_at', 'desc')
                ->paginate(5),

            'tenders' => Tender::where('status', 'Dalam Proses')
                ->doesntHave('surat_penawaran_harga')
                ->get(),
        ]);
    }
}
