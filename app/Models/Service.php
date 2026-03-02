<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Traits\HasAuditColumns;

class Service extends Model implements TranslatableContract
{
    use Translatable, HasAuditColumns, \App\Traits\HasTranslatedFields;

    protected $primaryKey = 'id_service';

    protected $translationForeignKey = 'id_service';

    public $translatedAttributes = ['name', 'slug', 'short_desc', 'content', 'meta_title', 'meta_desc'];

    protected $fillable = [
        'icon_class',
        'image_main',
        'sort_order',
        'is_active',
        'is_featured',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function benefits()
    {
        return $this->hasMany(ServiceBenefit::class, 'id_service')->orderBy('sort_order');
    }

    public function processes()
    {
        return $this->hasMany(ServiceProcess::class, 'id_service')->orderBy('step_number');
    }

    public function pricings()
    {
        return $this->hasMany(ServicePricing::class, 'id_service')->orderBy('sort_order');
    }
}
