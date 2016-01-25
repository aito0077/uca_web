<?php

namespace Uca;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Uca\Model\Role;
use Uca\Model\Organization;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'created_at', 'updated_at'];


     public function roles() {
         return $this->belongsToMany('Uca\Model\Role', 'users_roles');
     }
 
     public function isSiteUser() {
         $roles = $this->roles->toArray();
         return !empty($roles);
     }
 
     public function hasRole($check) {
         return in_array($check, array_fetch($this->roles->toArray(), 'name'));
     }
 
     private function getIdInArray($array, $term) {
         foreach ($array as $key => $value) {
             if ($value == $term) {
                 return $key;
             }
         }
 
         throw new UnexpectedValueException;
     }
 
     public function makeSiteUser($title) {
         $assigned_roles = array();
 
         $roles = array_fetch(Role::all()->toArray(), 'name');
 
         switch ($title) {
             case 'super_admin':
                 $assigned_roles[] = $this->getIdInArray($roles, 'edit_site');
                 $assigned_roles[] = $this->getIdInArray($roles, 'crud_user');
             case 'admin':
                 $assigned_roles[] = $this->getIdInArray($roles, 'edit_site');
                 $assigned_roles[] = $this->getIdInArray($roles, 'crud_user');
                 $assigned_roles[] = $this->getIdInArray($roles, 'create_region');
                 $assigned_roles[] = $this->getIdInArray($roles, 'create_competition');
             case 'community_editor':
                 $assigned_roles[] = $this->getIdInArray($roles, 'edit_region');
                 $assigned_roles[] = $this->getIdInArray($roles, 'crud_region_user');
                 $assigned_roles[] = $this->getIdInArray($roles, 'create_competition');
                 break;
             default:
                 throw new \Exception("The user status entered does not exist");
         }
 
         $this->roles()->attach($assigned_roles);
     }

    public function organizations() {
        return $this->belongsToMany('Uca\Model\Organization', 'organizations_users');
    }

}
