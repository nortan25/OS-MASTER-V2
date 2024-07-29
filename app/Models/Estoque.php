<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    protected $table = 'estoque';

    protected $fillable = [
        'user_id',
        'nome_produto',
        'tag_produto',
        'valor_produto',
        'codigo_sku',
        'quantidade',
        'descricao',
    ];

    // Aqui você pode definir relações com outros modelos, se necessário

    // Exemplo de relação com usuário (opcional)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
