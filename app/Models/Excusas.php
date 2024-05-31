<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Excusas extends Model
{
    use HasFactory, Notifiable;

    protected $guarded= ['id'];

    //scopes

    public function scopeSearch($query, $search)
    {
        if(strlen($search) > 0){
            return $query->where('grado', 'like', "%" . $search . "%");
        }else{
            return $query;
        }
    }
    public function scopeStatus($query, $filtro_estado)
    {
        if(strlen($filtro_estado) > 0){
            return $query->where('status', 'like', "%" . $filtro_estado . "%");
        }else{
            return $query;
        }
    }

    public function scopeMotivo($query, $filtro_motivo)
    {
        if(strlen($filtro_motivo) > 0){
            return $query->where('motivo', 'like', "%" . $filtro_motivo . "%");
        }else{
            return $query;
        }
    }

    public function scopeGrado($query, $filtro_grado)
    {
        if(strlen($filtro_grado) > 0){
            return $query->where('grado', 'like', "%" . $filtro_grado . "%");
        }else{
            return $query;
        }
    }

    public function scopeTecnica($query, $filtro_tecnica)
    {
        if(strlen($filtro_tecnica) > 0){
            return $query->where('tecnica', 'like', "%" . $filtro_tecnica . "%");
        }else{
            return $query;
        }
    }


    public function estudiante()
    {
        return $this->belongsTo(Estudiantes::class);
    }
// En tu modelo Excusa (app\Models\Excusa por defecto)

    protected static function boot(){
    parent::boot();

    static::creating(function ($excusa) {
        $ultimoCodigo = self::latest('id')->value('codigo');
        $nuevoNumero = $ultimoCodigo ? intval(substr($ultimoCodigo, 4)) + 1 : 1;

        // Formatea el código con la terminología EXC- y el nuevo número
        $excusa->codigo = 'EXC-' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
    });
}
}
