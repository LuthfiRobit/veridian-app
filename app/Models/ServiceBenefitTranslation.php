<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceBenefitTranslation extends Model
{
    protected $primaryKey = 'id_service_benefit_translation';
    public $timestamps = false;
    protected $fillable = ['title', 'description'];
}
