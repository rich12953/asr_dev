<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagsVideos extends Model
{
    protected $table = 'tags_videos';

    protected $primaryKey = 'id_tag_video';

    protected $fillable = array(
        'id_tag',
        'id_video',
    );

    public $timestamps = false;
}
