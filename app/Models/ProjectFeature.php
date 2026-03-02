<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ProjectFeature extends Model implements TranslatableContract
{
    use Translatable, \App\Traits\HasTranslatedFields;

    protected $primaryKey = 'id_project_feature';
    protected $translationForeignKey = 'id_project_feature';

    public $translatedAttributes = ['title', 'description'];

    protected $fillable = ['project_id', 'icon_class', 'sort_order'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
