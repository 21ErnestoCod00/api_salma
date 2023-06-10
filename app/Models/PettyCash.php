<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
{
    use HasFactory;

    protected $table = 'petty_cash';

    protected $fillable = [
        'month',
        'day',
        'zone_id',
        'reason',
        'document',
        'amount',
        'company_id',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
