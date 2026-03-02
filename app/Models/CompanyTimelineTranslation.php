<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyTimelineTranslation extends Model
{
    public $timestamps = false;
    protected $table = 'company_timeline_translations';
    protected $primaryKey = 'id_company_timeline_translation';

    protected $fillable = ['title', 'description'];
}
