<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectStatTranslation extends Model
{
    protected $primaryKey = 'id_project_stat_translation';
    public $timestamps = false;
    protected $fillable = ['label'];
}
