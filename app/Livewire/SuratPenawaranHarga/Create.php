<?php

namespace App\Livewire\SuratPenawaranHarga;

use App\Models\DocumentApprovalWorkflow;
use App\Models\SuratPenawaranHarga;
use App\Models\Tender;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

class Create extends Component
{
    use WithFileUploads;

    public $tender_id;
    public $nama_sph;
    public $file_path_sph;

    protected $rules = [
        'tender_id' => ['required', 'exists:tenders,id'],
        'nama_sph' => ['required', 'string', 'max:255'],
        'file_path_sph' => ['required', 'file', 'mimes:pdf', 'max:10240'],
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->tender_id = '';
        $this->nama_sph = '';
        $this->file_path_sph = null;
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
        $sph = SuratPenawaranHarga::create([
            'user_id' => auth()->user()->id,
            'tender_id' => $this->tender_id,
            'nama_sph' => $this->nama_sph,
            'file_path_sph' => $path,
        ]);

        // create status on document approval workflow
        DocumentApprovalWorkflow::create([
            'user_id' => auth()->user()->id,
            'surat_penawaran_harga_id' => $sph->id,
            'keterangan' => "Surat Penawaran Harga belum diperiksa oleh Manajer Admin",
            'level' => 0,
        ]);

        session()->flash('success', 'Surat Penawaran Harga berhasil diupload!');

        $this->dispatch('modal-closed', id: 'store');

        $this->resetForm();

        return redirect()->route('surat-penawaran-harga.index');
    }

    public function render()
    {
        return view('livewire.surat-penawaran-harga.create', [
            'tender_status' => Tender::where('status', 'Dalam Proses')
                ->doesntHave('surat_penawaran_harga')
                ->get(),
        ])->title('Buat Surat Penawaran Harga');
    }
}
