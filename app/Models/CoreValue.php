<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Traits\HasAuditColumns;
use App\Traits\HasTranslatedFields;

class CoreValue extends Model implements TranslatableContract
{
    use Translatable, HasAuditColumns, HasTranslatedFields;

    protected $table = 'core_values';
    protected $primaryKey = 'id_core_value';
    protected $translationForeignKey = 'id_core_value';

    public $translatedAttributes = ['title', 'description'];

    protected $fillable = [
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
