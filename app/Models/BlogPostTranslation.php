<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPostTranslation extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_blog_post_translation';

    public $timestamps = false;

    protected $fillable = [
        'id_blog_post',
        'locale',
        'slug',
        'title',
        'excerpt',
        'content',
        'meta_title',
        'meta_desc',
    ];
}
