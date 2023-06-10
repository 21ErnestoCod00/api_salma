<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;

    protected $table = 'revenues';

    protected $fillable = ['description', 'amount', 'date'];

    // Define la relación con la tabla "bank"
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
