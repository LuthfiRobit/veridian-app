<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Traits\HasTranslatedFields;

class CompanyProfile extends Model implements TranslatableContract
{
    use Translatable, HasTranslatedFields;

    protected $table = 'company_profiles';
    protected $primaryKey = 'id_company_profile';
    protected $translationForeignKey = 'id_company_profile';

    public $translatedAttributes = [
        'hero_badge',
        'hero_title',
        'hero_description',
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

    protected $fillable = [
        'stat_projects',
        'stat_clients',
        'stat_retention',
        'stat_experience',
        'stat_languages',
        'stat_satisfaction',
        'address',
        'phone',
        'email',
        'whatsapp',
        'google_maps_url',
        'social_facebook',
        'social_instagram',
        'social_twitter',
        'social_linkedin',
        'social_youtube',
        'social_tiktok',
        'about_image_main',
        'about_image_secondary',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get or create the singleton instance.
     */
    public static function singleton()
    {
        return static::firstOrCreate([], [
            'stat_projects' => '500+',
            'stat_clients' => '200+',
            'stat_retention' => '95%',
            'stat_experience' => '15+',
            'stat_languages' => '50+',
            'stat_satisfaction' => '98%',
        ]);
    }
}
