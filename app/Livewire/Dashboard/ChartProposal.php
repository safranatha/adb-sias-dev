<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class ChartProposal extends Component
{
    public function render()
    {
        return view('livewire.dashboard.chart-proposal',[
            'labels' => ['Belum Berjalan','Berjalan','Selesai'],
            'values' => [7,7,7],
        ]);
    }
}
