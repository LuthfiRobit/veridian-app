<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Traits\HasAuditColumns;

class TeamMember extends Model implements TranslatableContract
{
    use Translatable, HasAuditColumns, \App\Traits\HasTranslatedFields;

    protected $table = 'team_members';
    protected $primaryKey = 'id_team_member';
    protected $translationForeignKey = 'id_team_member';

    public $translatedAttributes = ['position', 'department', 'bio'];

    protected $fillable = [
        'name',
        'photo_path',
        'email',
        'linkedin_url',
        'twitter_url',
        'github_url',
        'is_active',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
