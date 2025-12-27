<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class ChartSph extends Component
{
    public function render()
    {
        return view('livewire.dashboard.chart-sph',[
            'labels' => ['Belum Berjalan','Berjalan','Selesai'],
            'values' => [7,20,7],
        ]);
    }
}
