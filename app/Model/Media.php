<?php namespace Uca\Model;

use Illuminate\Database\Eloquent\Model;
 
class Media extends Model {

    protected $fillable = [ 'name', 'ext', 'type', 'user_id', 'title', 'description'];

    protected $table = 'medias';

    public function user() {
        return $this->belongsTo('Uca\User');
    }

}
