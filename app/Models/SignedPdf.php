<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SignedPdf extends Model
{
    use HasFactory;

    protected $fillable = [
        'pdf_id',
        'path'
    ];

    public function cleanPdf() : BelongsTo
    {
        return $this->belongsTo(Pdf::class, 'pdf_id');
    }

    public function getPath() : string
    {
        return Storage::url($this->path);
    }
}
