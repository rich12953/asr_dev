<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $table = 'tags';

    protected $primaryKey = 'id_tag';

    protected $fillable = array(
        'titulo',
    );

    public $timestamps = false;

}
