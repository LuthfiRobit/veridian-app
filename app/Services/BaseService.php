<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

abstract class BaseService
{
    /**
     * Handle simple create with transaction
     */
    protected function atomic(callable $callback)
    {
        return DB::transaction($callback);
    }

    /**
     * Upload helper (placeholder for now)
     */
    protected function handleUpload($file, $path = 'uploads')
    {
        if (!$file)
            return null;
        return $file->store($path, 'public');
    }
}
