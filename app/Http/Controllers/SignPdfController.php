<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\PdfService;
use App\Services\SignPdfService;
use Illuminate\Contracts\View\View;
use App\Http\Requests\SignPdfRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class SignPdfController extends Controller
{
    public function __construct(
        protected readonly SignPdfService $service,
        protected readonly PdfService $pdfService
    ) {
    }

    public function create(): View
    {
        return view('signPdf.create');
    }

    public function store(SignPdfRequest $request): RedirectResponse
    {
        $pdf = $request->file('pdf');
        try {
            $uploadedPdf = $this->pdfService->upload($pdf->path(), $pdf->getClientOriginalName());
            $uploadedSignedPdf = $this->service->sign($request->signature, $uploadedPdf);

            $pdfModel = $this->pdfService->create([
                'name' => $pdf->getClientOriginalName(),
                'path' => $uploadedPdf
            ]);
            $this->service->create([
                'path' => $uploadedSignedPdf,
                'pdf_id' => $pdfModel->id
            ]);

            return redirect(route('sign-pdf.datatable'))->with('alert', setAlert('Uspešno ste potpisali PDF.'));
        } catch (\Exception $e) {
            if ($uploadedPdf) {
                $uploadedPdf = $this->pdfService->deleteByPath($uploadedPdf);
            }
            if ($uploadedSignedPdf) {
                $uploadedPdf = $this->service->deleteByPath($uploadedSignedPdf);
            }
            return back()->with('alert', setAlert('Došlo je do greške probajte ponovo.', 'danger'));
        }
    }
    public function datatable(): View
    {
        return view('signPdf.datatable');
    }

    public function datatableApi(): JsonResponse
    {
        return $this->service->datatable();
    }
}
