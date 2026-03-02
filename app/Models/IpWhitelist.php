<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditColumns;

class IpWhitelist extends Model
{
    use HasAuditColumns;

    protected $primaryKey = 'id_ip_whitelist';

    protected $fillable = [
        'ip_address',
        'label',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
