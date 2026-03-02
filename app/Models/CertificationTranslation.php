<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificationTranslation extends Model
{
    public $timestamps = false;
    protected $table = 'certification_translations';
    protected $primaryKey = 'id_certification_translation';

    protected $fillable = ['name', 'description'];
}
