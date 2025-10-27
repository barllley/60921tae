<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function exhibitions()
    {
        return $this->belongsToMany(Exhibition::class, 'exhibition_users')
                    ->withPivot('visited_at')
                    ->withTimestamps();
    }

    public function ticketInstances()
    {
        return $this->hasManyThrough(
            TicketInstance::class,
            Order::class,
            'user_id',      // Foreign key on orders table
            'order_id',     // Foreign key on ticket_instances table
            'id',           // Local key on users table
            'id'            // Local key on orders table
        );
    }

    public function tickets()
    {
        return $this->hasManyThrough(
            Ticket::class,
            TicketInstance::class,
            'order_id',     // Foreign key on ticket_instances table
            'id',           // Foreign key on tickets table
            'id',           // Local key on users table
            'ticket_id'     // Local key on ticket_instances table
        )->through('ticketInstances');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function cartTickets()
    {
        return $this->hasManyThrough(
            Ticket::class,
            CartItem::class,
            'user_id',
            'id',
            'id',
            'ticket_id'
        );
    }
}
