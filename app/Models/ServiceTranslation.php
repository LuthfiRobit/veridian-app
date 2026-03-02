<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTranslation extends Model
{
    protected $primaryKey = 'id_service_translation';

    protected $fillable = ['name', 'slug', 'short_desc', 'content', 'meta_title', 'meta_desc'];
}
