<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    protected $table = 'videos';

    protected $primaryKey = 'id_video';

    protected $fillable = array(
        'titulo',
    );

    public $timestamps = false;

    public function tagsPivot()
    {
        return $this->belongsToMany('App\Models\Tags', 'tags_posts', 'id_post', 'id_tag')->withPivot('id_tag_post');
    }

}
