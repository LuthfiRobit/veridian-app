<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoreValueTranslation extends Model
{
    public $timestamps = false;
    protected $table = 'core_value_translations';
    protected $primaryKey = 'id_core_value_translation';

    protected $fillable = ['title', 'description'];
}
