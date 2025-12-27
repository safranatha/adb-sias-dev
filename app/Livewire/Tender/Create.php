<?php

namespace App\Livewire\Tender;

use App\Models\Tender;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    public $nama_tender;
    public $nama_klien;
    public $file_pra_kualifikasi;

    protected $rules = [
        'nama_tender' => ['required', 'string', 'max:255'],
        'nama_klien' => ['required', 'string', 'max:255'],
        'file_pra_kualifikasi' => ['required', 'file'],
    ];

    public function mount()
    {
        $this->reset();
    }

    public function store()
    {
        $this->validate();

        // Save to Laravel storage
        $original = $this->file_pra_kualifikasi->getClientOriginalName();
        $timestamp = time();
        $format_timestamp = date('g i a,d-m-Y', $timestamp);
        $filename = "New" . "_" . $format_timestamp . "_" . $original;

        // Store to Laravel storage
        $path = $this->file_pra_kualifikasi->storeAs('file_pra_kualifikasi', $filename, 'public');
        

        Tender::create([
            'nama_tender' => $this->nama_tender,
            'nama_klien' => $this->nama_klien,
            'file_pra_kualifikasi' => $path
        ]);

        session()->flash('success', 'Tender berhasil dibuat!');

        // Redirect ke halaman index setelah berhasil create
        return $this->redirect('/tender', navigate: true);
    }

    #[Title('Buat Tender Baru')]
    public function render()
    {
        return view('livewire.tender.create');
    }
}
