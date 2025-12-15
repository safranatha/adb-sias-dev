<?php

namespace App\Livewire\InternalMemo;

use Livewire\Component;
use App\Models\InternalMemo;
use App\Models\Tender;
use Livewire\Attributes\Title;

class Create extends Component
{
    public $tender_id;
    public $nama_internal_memo;
    public $isi_internal_memo;

    protected $rules = [
        'tender_id' => 'required|exists:tenders,id',
        'nama_internal_memo' => 'required|string|max:255',
        'isi_internal_memo' => 'required|string',
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->tender_id = null;
        $this->nama_internal_memo = '';
        $this->isi_internal_memo = '';
    }

    public function store()
    {
        $this->validate();

        InternalMemo::create([
            'user_id' => auth()->user()->id,
            'tender_id' => $this->tender_id,
            'nama_internal_memo' => $this->nama_internal_memo,
            'isi_internal_memo' => $this->isi_internal_memo,
        ]);

        session()->flash('success', 'Internal Memo berhasil diupload!');

        return redirect()->route('internal-memo.index');
    }

    public function render()
    {
        return view('livewire.internal-memo.create', [
            'tenders' => Tender::where('status', 'Dalam Proses')
                ->doesntHave('proposal')
                ->get(),
        ])->title('Buat Internal Memo');
    }
}
