<?php

namespace App\Models;

use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class BlogCategory extends Model implements TranslatableContract
{
    use HasFactory, Translatable, HasAuditColumns, \App\Traits\HasTranslatedFields;

    protected $primaryKey = 'id_blog_category';
    protected $translationForeignKey = 'id_blog_category';

    public $translatedAttributes = ['name', 'slug'];

    protected $fillable = [
        'badge_color',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the posts associated with the category.
     */
    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'id_blog_category', 'id_blog_category');
    }
}
