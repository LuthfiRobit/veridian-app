<?php

namespace App\Http\Requests\Backend\IpWhitelist;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIpWhitelistRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ip_address' => 'required|ip|unique:ip_whitelists,ip_address,' . $this->route('ip_whitelist'), // Route parameter name usually matches strict resource or ID
            'label' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'id_ip_whitelist' => 'required|exists:ip_whitelists,id_ip_whitelist',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id_ip_whitelist' => $this->route('ip_whitelist') ?? $this->id_ip_whitelist,
        ]);

        // Normalize checkbox
        $this->merge([
            'is_active' => $this->has('is_active'),
        ]);
    }
}
