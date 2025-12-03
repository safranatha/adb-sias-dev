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
        $super_admin_role = Role::create(['name' => 'Super Admin']);
        $direktur_role = Role::create(['name' => 'Direktur']);
        $manajer_admin_role = Role::create(['name' => 'Manajer Admin']);
        $manajer_teknik_role = Role::create(['name' => 'Manajer Teknik']);
        $pic_role = Role::create(['name' => 'PIC']);
        $staff_teknik_role = Role::create(['name' => 'Staff Teknik']);
        $staff_admin_role = Role::create(['name' => 'Staff Admin']);
        $staff_penggadaan_role = Role::create(['name' => 'Staff Penggadaan']);

        // Create permissions
        // internal memo
        $view_permission_internal_memo = Permission::create(['name' => 'view internal memo']);
        $create_permission_internal_memo = Permission::create(['name' => 'create internal memo']);
        $edit_permission_internal_memo = Permission::create(['name' => 'edit internal memo']);
        $disposisi_permission_internal_memo = Permission::create(['name' => 'disposisi internal memo']);

        // proposal
        $view_permission_proposal = Permission::create(['name' => 'view proposal']);
        $create_permission_proposal = Permission::create(['name' => 'create proposal']);
        $validate_permission_proposal = Permission::create(['name' => 'validate proposal']);
        $assign_signature_number_permission_proposal = Permission::create(['name' => 'assign signature number proposal']);
        $disposisi_permsision_proposal = Permission::create(['name' => 'disposisi proposal']);

        // surat penawaran harga
        $view_permission_sph = Permission::create(['name' => 'view surat penawaran harga']);
        $create_permission_sph = Permission::create(['name' => 'create surat penawaran harga']);
        $validate_permission_sph = Permission::create(['name' => 'validate surat penawaran harga']);
        $assign_signature_number_permission_sph = Permission::create(['name' => 'assign signature number surat penawaran harga']);
        $disposisi_permsision_sph = Permission::create(['name' => 'disposisi surat penawaran harga']);

        // PIC
        $assign_pic_permission = Permission::create(['name' => 'assign pic']);

        // peta dan dokumen penyusun (dokumen pelaksanaan proyek div teknik)
        $view_permission_dokumen_pelaksanaan = Permission::create(['name' => 'view dokumen pelaksanaan']);
        $create_permission_dokumen_pelaksanaan = Permission::create(['name' => 'create dokumen pelaksanaan']);
        $validate_permission_dokumen_pelaksanaan = Permission::create(['name' => 'validate dokumen pelaksanaan']);
        $assign_signature_number_permission_dokumen_pelaksanaan = Permission::create(['name' => 'assign signature number dokumen pelaksanaan']);
        $disposisi_permsision_dokumen_pelaksanaan = Permission::create(['name' => 'disposisi dokumen pelaksanaan']);

        // surat tagihan
        $view_permission_surat_tagihan = Permission::create(['name' => 'view surat tagihan']);
        $create_permission_surat_tagihan = Permission::create(['name' => 'create surat tagihan']);
        $validate_permission_surat_tagihan = Permission::create(['name' => 'validate surat tagihan']);
        $assign_signature_number_permission_surat_tagihan = Permission::create(['name' => 'assign signature number surat tagihan']);
        $disposisi_permsision_surat_tagihan = Permission::create(['name' => 'disposisi surat tagihan']);

        // progress k/l
        $view_permission_progress_kl = Permission::create(['name' => 'view progress k/l']);
        $create_permission_progress_kl = Permission::create(['name' => 'create progress k/l']);

        // penggandaan
        $view_permission_penggandaan = Permission::create(['name' => 'view penggandaan']);
        $create_permission_penggandaan = Permission::create(['name' => 'create penggandaan']);
        $disposisi_permission_penggandaan = Permission::create(['name' => 'disposisi penggandaan']);

        // view projek
        $view_permission_projek = Permission::create(['name' => 'view projek']);

        // view tender
        $view_permission_tender = Permission::create(['name' => 'view tender']);

        // Assign permissions to roles
        // $adminRole->givePermissionTo($editPermission, $viewPermission);
        // $userRole->givePermissionTo($viewPermission);


        // Assign role to user
        $user = User::find(1); // Example user with ID 1
        $user->assignRole('Super Admin');
    }
}
