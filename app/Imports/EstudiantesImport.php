<?php

namespace App\Imports;

use App\Models\Estudiantes;
use App\Models\User;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EstudiantesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        if (empty($row['nombre_estudiante']) || empty($row['grado']) || empty($row['numero_identificacion'])) {
           // Alguno de los campos requeridos falta o está vacío, retornar null
            return null;

        }

        $padre = User::where('numero_identificacion', $row['numero_identificacion'])->first();

        $existingEstudiante = Estudiantes::where('name', $row['nombre_estudiante'])
        ->Where('grado', $row['grado'])
        ->first();
    if ($existingEstudiante == null && $padre != null) {
        $ultimoEstudiante = Estudiantes::orderBy('id', 'desc')->first();
        $ultimoCodigo = $ultimoEstudiante ? intval($ultimoEstudiante->codigo) : 20240000;

        // Generar el nuevo código sumando 1 al último código registrado
        $nuevoCodigo = $ultimoCodigo + 1;
        return new Estudiantes([

            'name' => $row['nombre_estudiante'],
            'codigo' => $nuevoCodigo,
            'grado' => $row['grado'],
            'tecnica' => mb_strtoupper($row['tecnica']),
            'ruta' => mb_strtoupper($row['ruta']),
            'padre_id' => $padre->id,
        ]);
    } else {

        return null;
    }

    }
}
