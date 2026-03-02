<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFeatureTranslation extends Model
{
    protected $primaryKey = 'id_project_feature_translation';
    public $timestamps = false;
    protected $fillable = ['title', 'description'];
}
