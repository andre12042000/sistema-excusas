<?php

namespace App\Http\Controllers;

use PDF;
use TCPDF;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mike42\Escpos\EscposImagen;
use App\Mail\EnvioComprobanteCorreo;
use Illuminate\Support\Facades\Mail;



class ExportController extends Controller
{


    public function enviarcorreo($tipo)
    {
        $mensaje = '';
        if($tipo == 'APROVADO'){
            $mensaje == 'Su excusa fue aprovada por el coordinador';
        }elseif($tipo == 'RECHAZADO'){
            $mensaje == 'Su excusa fue rechazada por el coordinador, Comunicate con el coordinador!';
        }else{
            $mensaje == 'Se detecto un ingreso al sistema de excusas, si no eres tu comunicate con el coordinador!';
        }
                $correo = new EnvioComprobanteCorreo($mensaje);
                Mail::to('sistemaexcusas.noresponder@gmail.com')->send($correo);

                return "Correo enviado";
            }

}
