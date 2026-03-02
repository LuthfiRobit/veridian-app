<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Traits\HasAuditColumns;
use App\Traits\HasTranslatedFields;

class CompanyTimeline extends Model implements TranslatableContract
{
    use Translatable, HasAuditColumns, HasTranslatedFields;

    protected $table = 'company_timelines';
    protected $primaryKey = 'id_company_timeline';
    protected $translationForeignKey = 'id_company_timeline';

    public $translatedAttributes = ['title', 'description'];

    protected $fillable = [
        'year',
        'icon_class',
        'sort_order',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
