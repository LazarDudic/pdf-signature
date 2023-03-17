<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Pdf;
use App\Enums\StoragePath;
use Illuminate\Support\Facades\Storage;

class PdfService
{
    public function upload(string $pdfPath, string $pdfName,  StoragePath $folder = StoragePath::PDF_PUBLIC): string
    {
        if (is_file($pdfPath)) {
            $pdfPath = file_get_contents($pdfPath);
        }
        $uniquePath = StorageService::getUniquePath($folder, $pdfName);
        Storage::put($uniquePath, $pdfPath);
        return $uniquePath;
    }

    public function create(array $data): Pdf
    {
        return Pdf::create($data);
    }

    public function deleteByPath(string $path): bool
    {
        $signed = Pdf::where('path', $path)->first();
        if ($signed) {
            $signed->delete();
        }
        Storage::delete($path);
        return true;
    }
}
