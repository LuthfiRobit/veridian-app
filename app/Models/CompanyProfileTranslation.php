<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfileTranslation extends Model
{
    public $timestamps = false;
    protected $table = 'company_profile_translations';
    protected $primaryKey = 'id_company_profile_translation';

    protected $fillable = [
        'about_title',
        'about_subtitle',
        'about_lead_text',
        'about_description',
        'mission_title',
        'mission_description',
        'vision_title',
        'vision_description',
        'footer_description',
    ];
}
