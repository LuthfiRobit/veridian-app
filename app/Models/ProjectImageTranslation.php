<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectImageTranslation extends Model
{
    protected $primaryKey = 'id_project_image_translation';
    public $timestamps = false;
    protected $fillable = ['caption'];
}
