<?php

namespace App\Livewire\Tender;

use App\Models\Tender;
use Livewire\Component;
use Livewire\Attributes\Title;

class Create extends Component
{
    public $nama_tender;
    public $nama_klien;

    protected $rules = [
        'nama_tender' => ['required', 'string', 'max:255'],
        'nama_klien' => ['required', 'string', 'max:255'],
    ];

    public function mount()
    {
        $this->reset();
    }

    public function store()
    {
        $this->validate();
        
        Tender::create([
            'nama_tender' => $this->nama_tender,
            'nama_klien' => $this->nama_klien,
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
