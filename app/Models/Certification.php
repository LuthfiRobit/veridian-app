<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Traits\HasAuditColumns;
use App\Traits\HasTranslatedFields;

class Certification extends Model implements TranslatableContract
{
    use Translatable, HasAuditColumns, HasTranslatedFields;

    protected $table = 'certifications';
    protected $primaryKey = 'id_certification';
    protected $translationForeignKey = 'id_certification';

    public $translatedAttributes = ['name', 'description'];

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
