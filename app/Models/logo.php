<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;

    protected $table = 'logos'; // Nome da tabela no banco de dados

    protected $fillable = [
        'user_id',
        'logo_base64',
    ];

    // Relação com o modelo User, se necessário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
