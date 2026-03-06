<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePricingTranslation extends Model
{
    protected $primaryKey = 'id_service_pricing_translation';
    public $timestamps = false;
    protected $fillable = ['name', 'price_label', 'unit_label', 'features_list', 'features_raw'];

    protected $casts = [
        'features_list' => 'array',
    ];
}
