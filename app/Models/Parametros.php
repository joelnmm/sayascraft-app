<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametros extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'parametros';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'parNombe',
        'parValor'
    ];

    use HasFactory;
}
