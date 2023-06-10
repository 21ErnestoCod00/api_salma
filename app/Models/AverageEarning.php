<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AverageEarning extends Model
{

    // PROMEDIO GANANCIAS

    use HasFactory;

    protected $table = 'average_earnings';
    protected $fillable = ['year', 'amount'];
}
