<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AverageExpense extends Model
{
    // PROMEDIO GASTOS

    use HasFactory;

    protected $table = 'average_expenses';

    protected $fillable = [
        'year',
        'amount',
    ];
}
