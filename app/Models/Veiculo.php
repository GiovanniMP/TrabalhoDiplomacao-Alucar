<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','ano', 'marca', 'imagem_marca', 'imagem_modelo', 'modelo' , 'contato', 'numero_portas', 'air_bag', 'abs', 'lugares','motor', 'transmissao', 'grupo', 'chassi', 'placa', 'cor', 'imagem'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function avaliacoes(){
        return $this->hasMany('App\Models\Avaliacao')->with('user');
    }

    public function alugado(){
        return $this->hasOne('App\Models\Alugado');
    }
}
