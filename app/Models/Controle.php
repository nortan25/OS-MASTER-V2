<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Controle extends Model
{
    use HasFactory;

    // Nome da tabela associada ao modelo
    protected $table = 'controle';

    // Os atributos que são atribuíveis em massa
    protected $fillable = [
        'user_id',
        'password',
        'ajustes',
        'historico_de_caixa'
    ];

    // Os atributos que devem ser convertidos para tipos nativos
    protected $casts = [
        'ajustes' => 'boolean',
        'historico_de_caixa' => 'boolean'
    ];

    // Indica se o modelo deve ser incrementado automaticamente pelo ID
    public $incrementing = true;

    // Indica se o modelo tem timestamps
    public $timestamps = true;

    // Adicionar relacionamentos, se necessário
    // Por exemplo, se 'user_id' é uma chave estrangeira para uma tabela de usuários
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
