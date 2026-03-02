<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ServicePricing extends Model implements TranslatableContract
{
    use HasFactory, Translatable, \App\Traits\HasTranslatedFields;

    protected $primaryKey = 'id_service_pricing';
    protected $translationForeignKey = 'id_service_pricing';
    public $translatedAttributes = ['name', 'price_label', 'unit_label', 'features_list'];
    protected $fillable = ['id_service', 'is_featured', 'sort_order', 'is_active'];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }
}
