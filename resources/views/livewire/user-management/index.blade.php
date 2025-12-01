<div class="max-w-6xl mx-auto mt-8">
    <a href="/register">
        <flux:button class="mb-4">Register</flux:button>
    </a>

    {{-- success message after post created --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-3 successMsg">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                document.getElementsByClassName('successMsg')?.remove();
            }, 200);
        </script>
    @endif

    <div class="overflow-x-auto rounded-xl border border-gray-200">
        <table class="w-full text-sm text-center">
            <thead class="bg-gray-100 text-black">
                <tr>
                    <th class="px-4 py-3 font-medium">Nama</th>
                    <th class="px-4 py-3 font-medium">Role</th>
                    <th class="px-4 py-3 font-medium">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @if ($users->isEmpty())
                    <tr>
                        <td colspan="3" class="px-4 py-6">
                            Tidak ada user untuk ditampilkan.
                        </td>
                    </tr>
                @else
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-4 py-3">{{ $user->name }}</td>

                            <td class="px-4 py-3">
                                {{-- kalau pakai Spatie Roles --}}
                                @foreach ($user->roles as $role)
                                    <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-md">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>

                            <td class="px-4 py-3">
                                <flux:button icon="pencil"></flux:button>
                                <flux:button icon="trash" variant="danger" wire:click="delete({{ $user->id }})"
                                    onclick="return confirm('Yakin hapus user?')"></flux:button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
