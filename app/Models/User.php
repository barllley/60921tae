<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Order;
use App\Models\Exhibition;
use App\Models\TicketInstance;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function exhibitions()
    {
        return $this->belongsToMany(Exhibition::class, 'exhibition_user')
                    ->withPivot('visited_at')
                    ->withTimestamps();
    }

    public function ticketInstances()
    {
        return $this->hasManyThrough(
            TicketInstance::class,
            Order::class,
            'user_id',             // Внешний ключ в промежуточной модели
            'order_id',            // Внешний ключ в целевой модели
            'id',                  // Локальный ключ
            'id'                   // Локальный ключ в промежуточной модели
        );
    }

    public function purchasedTickets()
    {
        return $this->hasManyThrough(
            Ticket::class,
            TicketInstance::class,
            'order_id', // Внешний ключ в TicketInstance
            'id',       // Внешний ключ в Ticket
            'id',       // Локальный ключ в User
            'ticket_id' // Локальный ключ в TicketInstance
        )->through('orders');
    }


    public function tickets()
    {
        return $this->hasManyThrough(
            Ticket::class,
            Order::class,
            'user_id',  // Внешний ключ в Order
            'id',       // Внешний ключ в Ticket
            'id',       // Локальный ключ в User
            'id'        // Локальный ключ в Order
        )->via('ticketInstances');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
