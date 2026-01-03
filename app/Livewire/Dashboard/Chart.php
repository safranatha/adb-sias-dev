<?php


// CHART TENDER 

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Chart extends Component
{
    public function render()
    {
        return view('livewire.dashboard.chart', [
            'labels' => ['Belum Berjalan','Berjalan','Selesai'],
            'values' => [10,7,20],
        ]);
    }
}
