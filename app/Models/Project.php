<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Traits\HasAuditColumns;

class Project extends Model implements TranslatableContract
{
    use Translatable, HasAuditColumns, \App\Traits\HasTranslatedFields;

    protected $primaryKey = 'id_project';
    protected $translationForeignKey = 'id_project';

    public $translatedAttributes = ['slug', 'title', 'subtitle', 'description', 'content', 'challenge', 'solution', 'result', 'tech_stack', 'meta_title', 'meta_desc'];

    protected $fillable = [
        'id_project_category',
        'client_name',
        'completion_date',
        'project_url',
        'image_thumbnail',
        'sort_order',
        'is_active',
        'is_featured',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'completion_date' => 'date',
        'tech_stack' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'id_project_category');
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class, 'project_id')->orderBy('sort_order');
    }

    public function stats()
    {
        return $this->hasMany(ProjectStat::class, 'project_id')->orderBy('sort_order');
    }

    public function features()
    {
        return $this->hasMany(ProjectFeature::class, 'project_id')->orderBy('sort_order');
    }
}
