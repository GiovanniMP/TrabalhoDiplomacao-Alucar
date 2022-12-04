<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;
    protected $table = 'avaliacoes';
    protected $fillable = ['avaliacao', 'comentario', 'user_id', 'veiculo_id'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function veiculo(){
        return $this->belongsTo('App\Models\Veiculo');
    }
}
