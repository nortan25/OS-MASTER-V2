<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    // Campos que podem ser preenchidos
    protected $fillable = [
        'tecnico',
        'atendente',
        'user_id', // Adiciona o campo user_id para associar ao usuário logado
    ];

    // Relacionamento para o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
