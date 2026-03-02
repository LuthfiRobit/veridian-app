<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditColumns;

class Language extends Model
{
    use HasAuditColumns;

    protected $primaryKey = 'id_language';

    protected $fillable = [
        'name',
        'code',
        'icon',
        'is_default',
        'is_active',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the default language code with caching.
     * Eliminates repeated DB queries across controllers and FormRequests.
     */
    public static function getDefaultCode(): string
    {
        return cache()->remember('default_language_code', 3600, function () {
            return static::where('is_default', true)->value('code') ?? 'en';
        });
    }

    /**
     * Clear the cached default language code.
     * Call this whenever default language changes.
     */
    public static function clearDefaultCodeCache(): void
    {
        cache()->forget('default_language_code');
    }
}
