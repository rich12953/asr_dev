<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $table = 'posts';

    protected $primaryKey = 'id_post';

    protected $fillable = array(
        'titulo',
    );

    public $timestamps = false;

    public function tags()
    {
        return $this->hasMany('App\Models\TagsPosts', 'id_post', 'id_post');
    }

    public function tagsPivot()
    {
        return $this->belongsToMany('App\Models\Tags', 'tags_posts', 'id_post', 'id_tag')->withPivot('id_tag_post');
    }

}
