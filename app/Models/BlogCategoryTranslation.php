<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategoryTranslation extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_blog_category_translation';

    public $timestamps = false;

    protected $fillable = [
        'id_blog_category',
        'locale',
        'name',
        'slug',
    ];
}
