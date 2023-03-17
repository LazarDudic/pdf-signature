<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pdf extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path'
    ];

    public function getPath() : string
    {
        return Storage::url($this->path);
    }

}
