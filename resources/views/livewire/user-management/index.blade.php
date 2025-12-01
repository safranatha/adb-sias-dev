<div class="max-w-6xl mx-auto mt-8">
    <a href="/register">
        <flux:button class="mb-4">Register</flux:button>
    </a>

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
                            {{-- <a href="{{ route('users.edit', $user->id) }}"
                                class="text-blue-600 hover:underline text-sm">
                                Edit
                            </a> --}}
                            <flux:button icon="pencil"></flux:button>
                            {{-- <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline text-sm"
                                    onclick="return confirm('Yakin hapus user?')">
                                    Delete
                                </button>
                            </form> --}}
                            <flux:button icon="trash" variant="danger"></flux:button>
                        </td>



                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
