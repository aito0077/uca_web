<?php
use Illuminate\Database\Seeder;
use Uca\User;
use Uca\Model\UserRole;
use Uca\Model\Role;
use Illuminate\Support\Facades\Hash;

class RolesTableSeeder extends Seeder {

    public function run() {
        DB::table('roles')->delete();


        $role = new Role();
        $role->name = 'edit_site';
        $role->description = 'Editar Sitio';
        $role->save();

        $role = new Role();
        $role->name = 'crud_user';
        $role->description = 'Manejo Usuarios';
        $role->save();

        $role = new Role();
        $role->name = 'crud_organization';
        $role->description = 'Crear Muestras';
        $role->save();

        $role = new Role();
        $userRole = new UserRole();
        $userRole->user_id = 1;
        $userRole->role_id = 1;
        $userRole->save();
        
        $userRole = new UserRole();
        $userRole->user_id = 1;
        $userRole->role_id = 2;
        $userRole->save();
 

        $userRole = new UserRole();
        $userRole->user_id = 2;
        $userRole->role_id = 3;
        $userRole->save();
 
        $userRole = new UserRole();
        $userRole->user_id = 2;
        $userRole->role_id = 2;
        $userRole->save();
 

     }

}




