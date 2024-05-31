<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function download($documento)
    {
        $ruta = public_path('storage/archivos/' . $documento);

        if (file_exists($ruta)) {
            return Response::download($ruta, $documento);
        } else {
            return abort(404);
        }
    }
}
