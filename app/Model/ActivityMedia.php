<?php namespace Uca\Model;

use Illuminate\Database\Eloquent\Model;
 
class ActivityMedia extends Model {

    protected $table = 'activities_medias';

    protected $fillable = ['media_id', 'activity_id'];

    public function media() {
        return $this->hasOne('Uca\Model\Media');
    }

    public function activity() {
        return $this->hasOne('Uca\Model\Activity');
    }

}

