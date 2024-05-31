<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesorGrados extends Model
{
    use HasFactory;
    protected $guarded= ['id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }
}
