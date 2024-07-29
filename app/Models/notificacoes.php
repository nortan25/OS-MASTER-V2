<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    protected $table = 'notificacoes'; // Definindo o nome da tabela

    protected $fillable = [
        'tipo', 
        'usuario_id', 
        'exibida_em', // Exemplo de campo adicional
    ];

    protected $dates = ['created_at', 'updated_at', 'exibida_em']; // Campos de data

    // Relacionamento com o usuário, se necessário
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
