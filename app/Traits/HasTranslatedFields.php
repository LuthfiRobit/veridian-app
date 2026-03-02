<?php

namespace App\Traits;

use App\Models\Language;

/**
 * Provides a convenient method to get translated field values
 * using the default language, with fallback to first available translation.
 *
 * Usage in DataTables:
 *   $row->getTranslated('name')
 *   $row->getTranslated('title', 'No Title')
 */
trait HasTranslatedFields
{
    /**
     * Get a translated field value for the default language,
     * falling back to the first available translation.
     *
     * @param string $field     The translation field name
     * @param string $fallback  Fallback value if no translation found
     * @return string|null
     */
    public function getTranslated(string $field, string $fallback = '—'): ?string
    {
        $locale = Language::getDefaultCode();

        // Use already-loaded translations (eager-loaded) to avoid extra queries
        $translation = $this->translations->firstWhere('locale', $locale);

        return $translation?->$field
            ?? $this->translations->first()?->$field
            ?? $fallback;
    }
}
