<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class TelegramConnectPage extends Component
{
    public function generateToken()
    {
        $rawToken = Str::upper(Str::random(32));

        auth()->user()->update([
            'telegram_connect_token' => hash('sha256', $rawToken),
        ]);

        session(['telegram_raw_token' => $rawToken]);
    }

    public function render()
    {
        return view('livewire.telegram-connect-page', [
            'user' => auth()->user(),
            'rawToken' => session('telegram_raw_token')
        ]);
    }
}

