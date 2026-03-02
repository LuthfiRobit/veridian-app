<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimonialTranslation extends Model
{
    protected $primaryKey = 'id_testimonial_translation';
    public $timestamps = false; // Translations generally don't need timestamps

    protected $fillable = [
        'client_position',
        'content',
    ];
}
