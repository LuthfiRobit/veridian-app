<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMemberTranslation extends Model
{
    public $timestamps = false;
    protected $table = 'team_member_translations';
    protected $primaryKey = 'id_team_member_translation';

    protected $fillable = ['position', 'department', 'bio'];
}
