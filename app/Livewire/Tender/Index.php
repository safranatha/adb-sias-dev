<?php

namespace App\Livewire\Tender;

use App\Models\Tender;
use Livewire\Component;
use Livewire\Attributes\Title;

class Index extends Component
{

    public $nama_tender;
    public $nama_klien;
    public $tender_id;
    public $isEditing = false;

    protected $rules = [
        'nama_tender' => ['required', 'string', 'max:255'],
        'nama_klien' => ['required', 'string', 'max:255'],
    ];

    public function mount()
    {
        $this->reset();
    }

    public function resetForm()
    {
        $this->nama_tender = '';
        $this->nama_klien = '';
        $this->isEditing = false;
        $this->tender_id = null;
    }

    public function edit($id)
    {
        $tender = Tender::findOrFail($id);
        $this->nama_tender = $tender->nama_tender;
        $this->nama_klien = $tender->nama_klien;
        $this->isEditing = true;
        $this->tender_id = $id;

    }

    public function download($id)
    {
        $file = Tender::findOrFail($id);

        if (!$file) {
            return session()->flash('error', 'File Pra kualifikasi tidak ditemukan.');
        }

        $file_path = public_path('storage/' . $file->file_pra_kualifikasi);

        if (!file_exists($file_path)) {
            return session()->flash('error', 'File Pra kualifikasi tidak ditemukan di storage.');
        }

        return response()->download($file_path);
    }

    public function update()
    {

        $rules = [];

        // Validasi hanya field yang diisi
        if ($this->nama_tender) {
            $rules['nama_tender'] = ['required', 'string', 'max:255'];
        }

        if ($this->nama_klien) {
            $rules['nama_klien'] = ['required', 'string', 'max:255'];
        }

        if (!empty($rules)) {
            $this->validate($rules);
        }

        // update db
        if ($this->nama_tender) {
            Tender::findOrFail($this->tender_id)->update([
                'nama_tender' => $this->nama_tender,
            ]);
        }

        if ($this->nama_klien) {
            Tender::findOrFail($this->tender_id)->update([
                'nama_klien' => $this->nama_klien,
            ]);
        }

        session()->flash('success', 'Tender berhasil diupdate!');

        $this->dispatch('modal-closed', id: $this->tender_id);

        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.tender.index', [
            'tenders' => Tender::orderBy('created_at', 'desc')->paginate(5),
        ])->title('Tender');
    }
}
