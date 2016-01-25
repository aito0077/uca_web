<?php namespace Uca\Model;

use Illuminate\Database\Eloquent\Model;
 
class Activity extends Model {

    protected $table = 'activities';

    protected $hidden = ['created_at', 'updated_at'];

    protected $dates = ['event_date'];

    public function organization() {
        return $this->belongsTo('Uca\Model\Organization');
    }

    public function medias() {
        return $this->belongsToMany('Uca\Model\Media', 'activities_medias');
    }
}



