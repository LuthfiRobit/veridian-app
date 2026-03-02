<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ProjectStat extends Model implements TranslatableContract
{
    use Translatable, \App\Traits\HasTranslatedFields;

    protected $primaryKey = 'id_project_stat';
    protected $translationForeignKey = 'id_project_stat';

    public $translatedAttributes = ['label'];

    protected $fillable = ['project_id', 'value', 'icon_class', 'sort_order'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
