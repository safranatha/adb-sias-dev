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
                                {{-- modal trigger --}}
                                <flux:modal.trigger name="edit-user-{{ $user->id }}">
                                    {{-- button edit --}}
                                    <flux:button icon="pencil" class="mr-2" wire:click="edit({{ $user->id }})"></flux:button>

                                </flux:modal.trigger>

                                {{-- modal form --}}
                                <flux:modal name="edit-user-{{ $user->id }}" class="max-w-2xl">
                                    <form wire:submit.prevent="update">
                                        <flux:heading size="lg">Edit User</flux:heading>
                                        {{-- Name Field --}}
                                        <flux:field>
                                            <flux:label>Name</flux:label>
                                            <flux:input wire:model="name" placeholder="Enter user name" />
                                        </flux:field>


                                        {{-- Email Field --}}
                                        <flux:field>
                                            <flux:label class="mt-3">Email</flux:label>
                                            <flux:input type="email" wire:model="email"
                                                placeholder="Enter user email" />
                                        </flux:field>

                                        {{-- Password Field --}}
                                        <flux:field>
                                            <flux:label class="mt-3">Password</flux:label>
                                            <flux:input type="password" wire:model="password"
                                                placeholder="Leave blank to keep current password" />
                                        </flux:field>

                                        {{-- Password Confirmation Field --}}
                                        <flux:field>
                                            <flux:label class="mt-3">Confirm Password</flux:label>
                                            <flux:input type="password" wire:model="password_confirmation"
                                                placeholder="Confirm new password" />
                                        </flux:field>

                                        {{-- Role Field --}}
                                        <flux:field>
                                            <flux:label class="mt-3">Role</flux:label>
                                            <flux:select wire:model="role" placeholder="Select role">
                                                @foreach ($roles as $r)
                                                    <flux:select.option value="{{ $r->name }}">
                                                        {{ ucfirst($r->name) }}
                                                    </flux:select.option>
                                                @endforeach
                                            </flux:select>
                                        </flux:field>

                                        {{-- Permissions Field --}}
                                        <flux:field>
                                            {{-- <x-multi-select label="Permission" name="permissions" :options="$permissions->pluck('name', 'name')"
                                                placeholder="Pilih permission" /> --}}
                                            <flux:label class="mt-3">Permission</flux:label>
                                            <div
                                                class="grid grid-cols-2 gap-3 max-h-48 overflow-y-auto border rounded-lg p-4 mt-1">
                                                @foreach ($allpermissions as $permission)
                                                    <label class="flex items-center gap-2 text-sm">
                                                        <input type="checkbox" wire:model="permissions"
                                                            value="{{ $permission->name }}"
                                                            class="rounded border-gray-300">
                                                        {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                                                    </label>
                                                @endforeach
                                            </div>

                                        </flux:field>

                                        <flux:spacer />
                                        <flux:button type="submit"  class="mt-6" variant="primary">
                                            Update User
                                        </flux:button>
                                    </form>
                                </flux:modal>

                                {{-- button delete --}}
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
