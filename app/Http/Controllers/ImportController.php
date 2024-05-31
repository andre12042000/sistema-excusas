<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\EstudiantesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport; // Asegúrate de importar la clase correcta

class ImportController extends Controller
{
    public function index()
    {
        return view('import');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
     Excel::import(new UsersImport, $file);


        return redirect()->route('import.index')->with('message', 'Usuarios importados con éxito.');
    }
//logica para importar estudiantes y buscar

    public function indexestudiantes()
    {
        return view('import-estudiantes');
    }


    public function importExcelEstudiantes(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
     Excel::import(new EstudiantesImport, $file);


        return redirect()->route('import.index.estudiantes')->with('message', 'Estudiantes importados con éxito.');
    }
}
