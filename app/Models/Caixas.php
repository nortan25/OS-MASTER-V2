<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caixas extends Model
{
    use HasFactory;

    protected $fillable = [
        'valor_inicial',
        'venda',
        'saida',
        'despesa_fixa',
        'total_dia',
        'user_id',
        'descricao',
        
    ];

    // Relacionamento com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    }

