<?php namespace Uca\Model;

use Illuminate\Database\Eloquent\Model;
 
class Organization extends Model {

    protected $hidden = ['created_at', 'updated_at'];

    public function products() {
        return $this->hasMany('Uca\Model\Product');
    }

    public function activities() {
        return $this->hasMany('Uca\Model\Activity');
    }

    public function medias() {
        return $this->belongsToMany('Uca\Model\Media', 'organizations_medias');
    }

    public function users() {
        return $this->belongsToMany('Uca\User', 'organizations_users');
    }


}




