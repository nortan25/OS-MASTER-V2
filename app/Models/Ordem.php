<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordem extends Model
{
    protected $table = 'ordems'; // Definindo o nome da tabela

    protected $fillable = [
        'modelo',
        'problema_relatado',
        'tecnico',
        'atendente',
        'cliente', // Adicionando os campos relacionados ao cliente ao $fillable
        'cidade',
        'cep',
        'rua',
        'numero',
        'bairro',
        'phone_number',
        'user_id',
        'state',
        'observacoes',

    ];

    // Se você quiser incluir os campos created_at e updated_at automaticamente,
    // pode definir $timestamps como true
    public $timestamps = true;

    // Aqui você pode adicionar outros relacionamentos e métodos conforme necessário
}
