<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Traits\HasAuditColumns;

class ProjectCategory extends Model implements TranslatableContract
{
    use Translatable, HasAuditColumns, \App\Traits\HasTranslatedFields;

    protected $primaryKey = 'id_project_category';
    protected $translationForeignKey = 'id_project_category';

    public $translatedAttributes = ['name', 'slug'];

    protected $fillable = [
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'id_project_category', 'id_project_category');
    }
}
