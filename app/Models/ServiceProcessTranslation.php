<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProcessTranslation extends Model
{
    protected $primaryKey = 'id_service_process_translation';
    public $timestamps = false;
    protected $fillable = ['title', 'description'];
}
