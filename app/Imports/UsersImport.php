<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['name']) || empty($row['email']) || empty($row['numero_identificacion'])) {
            // Alguno de los campos requeridos falta o está vacío, retornar null
            return null;
        }

        $telefono = preg_replace('/\D/', '', $row['telefono']); // Elimina todo lo que no sea un dígito

        $existingUser = User::where('email', $row['email'])
        ->orWhere('numero_identificacion', $row['numero_identificacion'])
        ->first();

    if ($existingUser == null) {
        return new User([

            'name' => $row['name'] . ' ' . $row['apellido'],
            'email' => strtolower($row['email']),
            'password' => bcrypt($row['numero_identificacion']),
            'telefono' => $telefono,
            'direccion' => $row['direccion'],
            'numero_identificacion' => $row['numero_identificacion'],
            'firma' => null,
        ]);
    } else {

        return null;
    }

    }
}
