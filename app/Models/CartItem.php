<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'ticket_id',
        'quantity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->ticket->price * $this->quantity;
    }

    public function scopeByIdentifier($query, $identifier, $type)
    {
        if ($type === 'user_id') {
            return $query->where('user_id', $identifier);
        } else {
            return $query->where('session_id', $identifier);
        }
    }
}
