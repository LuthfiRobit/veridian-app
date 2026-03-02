<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCategoryTranslation extends Model
{
    protected $primaryKey = 'id_project_category_translation';

    protected $fillable = ['name', 'slug'];
}
