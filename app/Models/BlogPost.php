<?php

namespace App\Models;

use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class BlogPost extends Model implements TranslatableContract
{
    use HasFactory, Translatable, HasAuditColumns, \App\Traits\HasTranslatedFields;

    protected $primaryKey = 'id_blog_post';
    protected $translationForeignKey = 'id_blog_post';

    public $translatedAttributes = [
        'slug',
        'title',
        'excerpt',
        'content',
        'meta_title',
        'meta_desc',
    ];

    protected $fillable = [
        'id_blog_category',
        'id_author',
        'image_featured',
        'status',
        'published_at',
        'reading_time',
        'views_count',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Get the category that owns the post.
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'id_blog_category', 'id_blog_category');
    }

    /**
     * Get the author that wrote the post.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'id_author', 'id_user');
    }
}
