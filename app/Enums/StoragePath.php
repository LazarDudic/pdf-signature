<?php

namespace App\Enums;

enum StoragePath: string
{
    case PDF_PUBLIC = 'public/pdf/';
    case SIGNED_PDF_PUBLIC = 'public/signature/';
}
