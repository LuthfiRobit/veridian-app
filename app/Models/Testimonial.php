<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Traits\HasAuditColumns;

class Testimonial extends Model implements TranslatableContract
{
    use Translatable, HasAuditColumns, \App\Traits\HasTranslatedFields;

    protected $primaryKey = 'id_testimonial';
    protected $translationForeignKey = 'id_testimonial';

    public $translatedAttributes = ['client_position', 'content'];

    protected $fillable = [
        'id_project',
        'client_name',
        'avatar_path',
        'rating',
        'is_active',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating' => 'integer',
        'sort_order' => 'integer',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project', 'id_project');
    }
}
