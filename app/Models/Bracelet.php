<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bracelet extends Model
{
    protected $primaryKey = 'id';

    /**
     * @var string $table
     */
    protected $table = 'bracelets';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'type',
        'size',
        'name',
        'colors',
        'quantity',
        'image',
        'price'
    ];

    use HasFactory;
}
