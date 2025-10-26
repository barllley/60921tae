<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function ticketInstances()
    {
        return $this->hasMany(TicketInstance::class);
    }

    public function tickets()
    {
        return $this->hasManyThrough(Ticket::class, TicketInstance::class, 'order_id', 'id', 'id', 'ticket_id');
    }
}
