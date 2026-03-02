<?php

namespace App\Http\Requests\Backend\IpWhitelist;

use Illuminate\Foundation\Http\FormRequest;

class StoreIpWhitelistRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ip_address' => 'required|ip|unique:ip_whitelists,ip_address',
            'label' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }
}
