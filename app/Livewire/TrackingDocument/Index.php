<?php

namespace App\Livewire\TrackingDocument;

use App\Models\Tender;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $searchInput = ''; // isi input
    public string $search = '';      // dipakai query

    public function searchTender()
    {
        $this->resetPage();
        // nilai baru dikunci saat tombol diklik
        $this->search = $this->searchInput;
    }

    public function render()
    {

        $tenders = collect(); // default kosong

        if ($this->search !== '') {
            $tenders = Tender::search($this->search)
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }

        return view('livewire.tracking-document.index', compact('tenders'))->title('Tracking Document');
    }
}
