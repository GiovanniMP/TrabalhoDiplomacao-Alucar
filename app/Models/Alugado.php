<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alugado extends Model
{
    use HasFactory;
    protected $fillable = ['veiculo_id', 'preco', 'data', 'user_id'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function veiculo(){
        return $this->belongsTo('App\Models\Veiculo');
    }
}
