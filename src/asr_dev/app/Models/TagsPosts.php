<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagsPosts extends Model
{
    protected $table = 'tags_posts';

    protected $primaryKey = 'id_tag_post';

    protected $fillable = array(
        'id_tag',
        'id_post',
    );

    public $timestamps = false;
}
