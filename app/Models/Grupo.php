<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    protected $fillable = ['grupo', 'domingo', 'segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'madrugada', 'dia', 'noite'];
}
