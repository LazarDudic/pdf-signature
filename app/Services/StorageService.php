<?php
declare(strict_types=1);

namespace App\Services;

use App\Enums\StoragePath;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    public static function getUniquePath(StoragePath $folder, string $name): string
    {
        $path = $folder->value . $name;
        while (Storage::exists($path)) {
            $name = Str::random(10) . '-' . $name;
            $path = $folder->value . $name;
        }

        return $path;
    }
}
