<?php namespace Uca\Model;

use Illuminate\Database\Eloquent\Model;
 
class UserRole extends Model {

    protected $table = 'users_roles';

    protected $fillable = ['user_id', 'role_id'];

    public function user() {
        return $this->hasOne('Uca\User');
    }

    public function role() {
        return $this->hasOne('Uca\Model\Role');
    }


}

