<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SignedPdf;
use App\Enums\StoragePath;
use App\Services\PdfService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class SignPdfService
{
    public function sign(string $signature, string $path): string
    {
        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        $lastPage = $pdf->setSourceFile(Storage::path($path));
        for ($i = 1; $i <= $lastPage; $i++) {
            $pdf->AddPage();
            $pdf->useTemplate($pdf->importPage($i));
        }
        $pdf->setPage($lastPage, true);
        $encodedImage = explode(",", $signature)[1];
        $decodedImage = base64_decode($encodedImage);
        $pdf->Image('@' . $decodedImage, $pdf->getPageWidth() - 70, $pdf->getPageHeight() - 60, 60);
        return (new PdfService)->upload($pdf->Output('', 'S'), 'signature.pdf', StoragePath::SIGNED_PDF_PUBLIC);
    }

    public function create(array $data): SignedPdf
    {
        return SignedPdf::create($data);
    }

    public function deleteByPath(string $path): bool
    {
        $signed = SignedPdf::where('path', $path)->first();
        if ($signed) {
            $signed->delete();
        }
        Storage::delete($path);
        return true;
    }

    public function datatable(): JsonResponse
    {
        $query = SignedPdf::with('cleanPdf');
        return datatables()->eloquent($query)
            ->addColumn('name', function (SignedPdf $signed) {
                return $signed->cleanPdf->name;
            })
            ->editColumn('created_at', function (SignedPdf $signed) {
                return $signed->created_at->format('d.m.Y h:i');
            })
            ->editColumn('path', function (SignedPdf $signed) {
                return "<a target='_blank' href='" . $signed->getPath() . "'>Pogledaj ↗</a>";
            })
            ->editColumn('cleanPath', function (SignedPdf $signed) {
                return "<a target='_blank' href='" . $signed->cleanPdf->getPath() . "'>Pogledaj ↗</a>";
            })
            ->escapeColumns()
            ->rawColumns(['path', 'cleanPath'])
            ->toJson();
    }
}
