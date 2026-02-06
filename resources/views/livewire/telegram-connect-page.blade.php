<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="max-w-xl mx-auto mt-10 p-6 border rounded-lg">

        <h2 class="text-xl font-bold mb-4">
            🔔 Hubungkan Telegram
        </h2>

        {{-- STATUS --}}
        @if ($user->telegram_chat_id)
            <div class="p-4 bg-green-100 rounded mb-4">
                ✅ Telegram sudah terhubung
            </div>
        @else
            <div class="p-4 bg-yellow-100 rounded mb-4">
                ⚠️ Telegram belum terhubung
            </div>
        @endif

        {{-- JIKA BELUM CONNECT --}}
        @if (!$user->telegram_chat_id)

            <p class="mb-3 text-sm text-gray-700">
                Untuk menerima notifikasi, hubungkan akun Telegram Anda.
            </p>

            <ol class="list-decimal ml-5 text-sm mb-4">
                <li>Klik tombol <b>Generate Token</b></li>
                <li>Kemudian, klik <b>Hubungkan</b></li>
                <li>Anda akan dialihkan ke Telegram</li>
                <li>Kemudian, pilih <b>Start Bot</b>, dan <b>Kirim Pesan</b> yang ada</li>
            </ol>

            {{-- TOMBOL GENERATE --}}
            <button wire:click="generateToken" class="px-4 py-2 bg-blue-600 text-white rounded">
                🔑 Generate Token
            </button>

            {{-- TAMPILKAN TOKEN --}}
            @if ($rawToken)
                <div class="mt-4 p-3 bg-gray-100 rounded">
                    <a href="https://t.me/sias_adi_banuwa_bot?text=/connect%20{{ $rawToken }}" target="_blank"
                        class="text-blue-600 hover:underline">Hubungkan</a>
                </div>
            @else
                <div class="mt-4 p-3 bg-gray-100 rounded">
                    <span class="text-gray-400 cursor-not-allowed">
                        Hubungkan
                    </span>
                </div>
            @endif


        @endif

    </div>

</div>
