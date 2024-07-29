<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloOrdem extends Model
{
    use HasFactory;

    // Nome da tabela associada ao modelo
    protected $table = 'modelo_ordem';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'modelo_1',
        'modelo_2',
        'modelo_3',
        'modelo_4',
        'user_id',
    ];

    // Campos que são do tipo timestamp e devem ser gerenciados automaticamente
    public $timestamps = true;

    // Opcional: Se você deseja definir o nome dos campos de timestamp manualmente
    // const CREATED_AT = 'created_at';
    // const UPDATED_AT = 'updated_at';
}
