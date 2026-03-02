<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ServiceBenefit extends Model implements TranslatableContract
{
    use HasFactory, Translatable, \App\Traits\HasTranslatedFields;

    protected $primaryKey = 'id_service_benefit';
    protected $translationForeignKey = 'id_service_benefit';
    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['id_service', 'icon_class', 'sort_order', 'is_active'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }
}
