<?php

namespace App\Livewire\Proposal;

use App\Models\Proposal;
use App\Models\Tender;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'tailwind';

    public $tender_id;
    public $nama_proposal;
    public $file_path_proposal;


    protected $rules = [
        'tender_id' => ['required', 'exists:tenders,id'],
        'nama_proposal' => ['required', 'string', 'max:255'],
        'file_path_proposal' => ['required', 'file', 'mimes:pdf', 'max:10240'],
    ];

    public function store()
    {
        // dd($this->tender_id, $this->nama_proposal, $this->file_path_proposal);
        $this->validate();

        // save to laravel storage
        $path = $this->file_path_proposal->store('proposals', 'public');

        // save to database
        Proposal::create([
            'user_id' => auth()->user()->id,
            'tender_id' => $this->tender_id,
            'nama_proposal' => $this->nama_proposal,
            'file_path_proposal' => $path,
        ]);

        $this->reset();

        session()->flash('success', 'Proposal berhasil diupload!');

        return redirect()->route('proposal.index');
    }


    public function render()
    {
        // dd(Proposal::all());
        return view('livewire.proposal.index', [
            'proposals' => Proposal::with(['tender', 'user'])->paginate(5),
            'tenders' => Tender::where('status', 'Dalam Proses')
                ->doesntHave('proposal')
                ->get(),
        ]);
    }
}
