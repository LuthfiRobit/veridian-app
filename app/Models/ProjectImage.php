<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ProjectImage extends Model implements TranslatableContract
{
    use Translatable, \App\Traits\HasTranslatedFields;

    protected $primaryKey = 'id_project_image';
    protected $translationForeignKey = 'id_project_image';

    public $translatedAttributes = ['caption'];

    protected $fillable = ['project_id', 'image_path', 'is_hero', 'sort_order'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
