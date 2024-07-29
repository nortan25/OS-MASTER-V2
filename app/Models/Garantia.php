<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garantia extends Model
{
    use HasFactory;

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'cep',
        'city',
        'neighborhood',
        'street',
        'house_number',
        'state',
        'tipoGarantia',
        'nomeProduto',
        'tempoGarantiaProduto',
        'servicoRealizado',
        'modeloAparelho',
        'tempoGarantiaServico',
        'user_id', // Adicionando o campo user_id aos campos preenchíveis
        'observacoes',
    ];
}
