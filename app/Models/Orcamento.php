<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    // Define o nome da tabela, caso seja diferente do padrão (plural do nome do modelo)
    protected $table = 'orcamentos';

    // Campos que podem ser preenchidos em massa
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

    public $timestamps = true;
}
