<?php

namespace App\Livewire\UserManagement;

use Livewire\Component;
use App\Models\User;

class Index extends Component
{

    public function delete($id)
    {
        $user = User::findOrFail($id);

        // Clear cache Spatie Permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Hapus role-role-nya dulu (Spatie)
        $user->syncRoles([]);

        // Hapus user
        $user->delete();

        session()->flash('success', 'User berhasil dihapus.');
        return redirect()->route('user-management.index');
    }

    public function render()
    {
        return view('livewire.user-management.index', [
            'users' => User::with('roles')
                ->where('id', '!=', auth()->id()) // exclude user yang sedang login
                ->paginate(10),
        ]);
    }

}
