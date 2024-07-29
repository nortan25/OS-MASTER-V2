<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'cep',
        'state',
        'cpf_cnpj',
        'city',
        'neighborhood',
        'street',
        'house_number',
        'user_id', // Adicionar 'user_id' aos atributos preenchíveis
    ];
}
