<?php

namespace App\Livewire\UserManagement;

use Livewire\Component;
use App\Models\User;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    public User $user;

    // Deklarasi property publik
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $role;
    public $permissions = [];

    public $isEditing = false;
    public $editingUserId = null;

    public function rules()
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->editingUserId),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable', 'string', Rule::exists('roles', 'name')],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::exists('permissions', 'name')],
        ];
    }

    public function mount()
    {
        // Reset properties
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = '';
        $this->permissions = [];
        $this->isEditing = false;
        $this->editingUserId = null;
        $this->resetValidation();
    }

    public function edit($id)
    {
        $user = User::with('roles', 'permissions')->findOrFail($id);

        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = $user->roles->first()?->name ?? '';
        $this->permissions = $user->getDirectPermissions()->pluck('name')->toArray();

        $this->isEditing = true;
    }


    public function update(){
        $this->validate();
        $user = User::findOrFail($this->editingUserId);

        // Update user
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        // Update password
        if ($this->password) {
            $user->update([
                'password' => bcrypt($this->password),
            ]);
        }

        // Update role
        $user->syncRoles([$this->role]);

        // update permission
        if ($this->permissions) {
            $user->syncPermissions($this->permissions);
        } else {
            $user->syncPermissions([]);
        }

        // hapus cache Spatie Permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        session()->flash('success', 'User berhasil diupdate.');

        $this->resetForm();

        return redirect()->route('user-management.index');
    }

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
            'roles' => Role::all()->where('id', '!=', 1),
            'allpermissions' => Permission::all(),
        ]);
    }

}
