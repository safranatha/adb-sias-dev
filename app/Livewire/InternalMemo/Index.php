<?php

namespace App\Livewire\InternalMemo;

use Livewire\Component;
use App\Models\InternalMemo;
use Livewire\WithPagination;
use App\Models\Tender;
use Livewire\Attributes\Title;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $tender_id;
    public $nama_internal_memo;
    public $isi_internal_memo;

    public $internal_memo_id;
    public $isEditing = false;

    protected $rules = [
        'tender_id' => 'required|exists:tenders,id',
        'nama_internal_memo' => 'required|string|max:255',
        'isi_internal_memo' => 'required|string',
    ];

    public function mount()
    {
        // Reset properties
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->tender_id = null;
        $this->nama_internal_memo = '';
        $this->isi_internal_memo = '';
        $this->isEditing = false;
        $this->proposal_id = null;
    }


    public function edit($id)
    {
        $internalMemo = InternalMemo::findOrFail($id);
        $this->tender_id = $internalMemo->tender_id;
        $this->nama_internal_memo = $internalMemo->nama_internal_memo;
        $this->isi_internal_memo = $internalMemo->isi_internal_memo;
        $this->isEditing = true;
        $this->internal_memo_id = $internalMemo->id;
    }

    public function update()
    {
        $this->validate();

        $internalMemo = InternalMemo::findOrFail($this->internal_memo_id);
        $internalMemo->update([
            'tender_id' => $this->tender_id,
            'nama_internal_memo' => $this->nama_internal_memo,
            'isi_internal_memo' => $this->isi_internal_memo,
        ]);

        // Reset form fields
        $this->resetForm();

        session()->flash('success', 'Internal Memo berhasil diperbarui!');

        return redirect()->route('internal-memo.index');
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

        // Reset form fields
        $this->reset(['tender_id', 'nama_internal_memo', 'isi_internal_memo']);

        session()->flash('success', 'Internal Memo berhasil diupload!');

        return redirect()->route('internal-memo.index');
    }

    public function render()
    {
        return view('livewire.internal-memo.index',[
            'internalMemos' => InternalMemo::all(),
            'tenders' => Tender::where('status', 'Dalam Proses')
                ->doesntHave('proposal')
                ->get(),
        ])->title('Internal Memo');
    }
}
