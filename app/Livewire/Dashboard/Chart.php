<?php


// CHART TENDER 

namespace App\Livewire\Dashboard;

use App\Models\Tender;
use Livewire\Component;

class Chart extends Component
{
    public function render()
    {
        $gagal=Tender::where('status','=','Gagal')->count();
        $berhasil=Tender::where('status','=','Berhasil')->count();
        $dalam_proses=Tender::where('status','=','Dalam Proses')->count();
        return view('livewire.dashboard.chart', [
            'labels' => ['Gagal','Berhasil','Dalam Proses'],
            'values' => [$gagal,$berhasil,$dalam_proses],
        ]);
    }
}
