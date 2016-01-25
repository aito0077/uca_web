<?php namespace Uca\Model;

use Illuminate\Database\Eloquent\Model;
 
class Page extends Model {

    protected $hidden = ['created_at', 'updated_at'];

    public function medias() {
        return $this->belongsToMany('Uca\Model\Media', 'pages_medias');
    }

}





