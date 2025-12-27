<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Direktur']);
        Role::create(['name' => 'Assisten Direktur']);
        Role::create(['name' => 'Manajer Admin']);
        Role::create(['name' => 'Manajer Teknik']);
        Role::create(['name' => 'PIC']);
        Role::create(['name' => 'Staff Teknik']);
        Role::create(['name' => 'Staff Admin']);
        Role::create(['name' => 'Staff Penggadaan']);

        // Create permissions
        // form tugas
        Permission::create(['name' => 'create form tugas']);
        Permission::create(['name' => 'edit form tugas']);

        // permission to assign dokumen tender
        Permission::create(['name' => 'assign dokumen tender']);

        // proposal
        Permission::create(['name' => 'view proposal']);
        Permission::create(['name' => 'create proposal']);
        Permission::create(['name' => 'validate proposal']);

        // surat penawaran harga
        Permission::create(['name' => 'view surat penawaran harga']);
        Permission::create(['name' => 'create surat penawaran harga']);
        Permission::create(['name' => 'validate surat penawaran harga']);

        // PIC
        Permission::create(['name' => 'assign pic']);

        // peta dan dokumen penyusun (dokumen pelaksanaan proyek div teknik)
        Permission::create(['name' => 'view dokumen pelaksanaan']);
        Permission::create(['name' => 'create dokumen pelaksanaan']);
        Permission::create(['name' => 'validate dokumen pelaksanaan']);
        Permission::create(['name' => 'assign signature number dokumen pelaksanaan']);

        // surat tagihan
        Permission::create(['name' => 'view surat tagihan']);
        Permission::create(['name' => 'create surat tagihan']);
        Permission::create(['name' => 'validate surat tagihan']);
        Permission::create(['name' => 'assign signature number surat tagihan']);

        // progress k/l
        Permission::create(['name' => 'view progress k/l']);
        Permission::create(['name' => 'create progress k/l']);

        // penggandaan
        Permission::create(['name' => 'view penggandaan']);
        Permission::create(['name' => 'create penggandaan']);

        // view projek
        Permission::create(['name' => 'view projek']);
        // create projek
        Permission::create(['name' => 'create projek']);

        // view tender
        Permission::create(['name' => 'view tender']);
        // create tender
        Permission::create(['name' => 'create tender']);

        // ===== ASSIGN PERMISSION ROLE =====
        $rolePermissions = [          
            'Direktur' => [
                'create form tugas',
                'view tender',
                'create tender',
                'validate proposal',
                'validate surat penawaran harga',
                'assign dokumen tender',
            ],

            'Assisten Direktur' => [
                'create form tugas',
            ],

            'Manajer Admin' => [
                'create form tugas',
                'view proposal',
                'view surat penawaran harga',
                'validate surat penawaran harga',
            ],

            'Manajer Teknik' => [
                'create form tugas',
                'view proposal',
                'validate proposal',
            ],

            'Staff Teknik' => [
                'view proposal',
                'create proposal',
            ],

            'Staff Admin' => [
                'view surat penawaran harga',
                'create surat penawaran harga',
            ],
        ];

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->syncPermissions($permissions);
            }
        }

        // ===== ASSIGN ROLES KE USERS (SETELAH PERMISSION SUDAH DI-ASSIGN KE ROLE) =====
        $userRoles = [
            1 => 'Super Admin',
            2 => 'Direktur',
            3 => 'Assisten Direktur',
            4 => 'Manajer Teknik',
            5 => 'Manajer Admin',
            6 => 'Staff Teknik',
            7 => 'Staff Admin',
        ];

        foreach ($userRoles as $userId => $roleName) {
            $user = User::find($userId);
            if ($user) {
                $user->assignRole($roleName);
            }
        }
    }
}
