<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTranslation extends Model
{
    protected $primaryKey = 'id_project_translation';

    protected $fillable = ['slug', 'title', 'subtitle', 'description', 'content', 'challenge', 'solution', 'result', 'tech_stack', 'meta_title', 'meta_desc'];

    protected $casts = [
        'tech_stack' => 'array',
    ];
}
