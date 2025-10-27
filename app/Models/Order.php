<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
    ];

    /*Пользователь, которому принадлежит заказ */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*билеты*/
    public function ticketInstances(): HasMany
    {
        return $this->hasMany(TicketInstance::class);
    }

    /* Платеж для этого заказа*/
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
