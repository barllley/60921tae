<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'exhibition_id',
        'type',
        'price',
        'available_quantity',
    ];

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }
}
