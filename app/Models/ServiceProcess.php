<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ServiceProcess extends Model implements TranslatableContract
{
    use HasFactory, Translatable, \App\Traits\HasTranslatedFields;

    protected $primaryKey = 'id_service_process';
    protected $translationForeignKey = 'id_service_process';
    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['id_service', 'step_number', 'is_active'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }
}
