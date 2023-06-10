<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    // protected $table = 'banks';

    protected $fillable = ['name', 'slog'];

    // Define la relación con la tabla "revenue"
    public function revenues()
    {
        return $this->hasMany(Revenue::class);
    }
}
