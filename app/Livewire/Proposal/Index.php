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
    public $proposal_id;
    public $isEditing = false;

    protected $rules = [
        'tender_id' => ['required', 'exists:tenders,id'],
        'nama_proposal' => ['required', 'string', 'max:255'],
        'file_path_proposal' => ['required', 'file', 'mimes:pdf', 'max:10240'],
    ];

    public function mount()
    {
        // Reset properties
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->tender_id = '';
        $this->nama_proposal = '';
        $this->file_path_proposal = '';
        $this->isEditing = false;
        $this->proposal_id = null;

    }

    public function edit($id)
    {
        $proposal = Proposal::findOrFail($id);
        $this->tender_id = $proposal->tender_id;
        $this->nama_proposal = $proposal->nama_proposal;
        $this->file_path_proposal = $proposal->file_path_proposal;
        $this->isEditing = true;
        $this->proposal_id = $id;
    }

    public function download($id){
        $proposal = Proposal::findOrFail($id);

        return response()->download(public_path('storage/' . $proposal->file_path_proposal));
    }

    public function update()
    {

        if ($this->nama_proposal) {
            Proposal::findOrFail($this->proposal_id)->update([
                'nama_proposal' => $this->nama_proposal,
            ]);
        }

        if ($this->file_path_proposal instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $original = $this->file_path_proposal->getClientOriginalName();
            $timestamp = time();
            $format_timestamp = date('g i a,d-m-Y', $timestamp);
            $filename = "Revision" . "_" . $format_timestamp . "_" . $original;

            $path = $this->file_path_proposal->storeAs('proposals', $filename, 'public');

            Proposal::findOrFail($this->proposal_id)->update([
                'file_path_proposal' => $path,
            ]);
        }


        session()->flash('success', 'Proposal berhasil diupdate!');

        $this->resetForm();

        return redirect()->route('proposal.index');
    }


    public function store()
    {
        // dd($this->tender_id, $this->nama_proposal, $this->file_path_proposal);
        $this->validate();

        // save to laravel storage
        $original = $this->file_path_proposal->getClientOriginalName();
        $timestamp = time();
        $format_timestamp = date('g i a,d-m-Y', $timestamp);
        $filename = "New" . "_" . $format_timestamp . "_" . $original;
        // store to laravel storage
        $path = $this->file_path_proposal->storeAs('proposals', $filename, 'public');

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
