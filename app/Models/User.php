<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Order;
use App\Models\Exhibition;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Отношение многие-ко-многим с выставками
    public function exhibitions()
    {
        return $this->belongsToMany(Exhibition::class, 'exhibition_user')
                    ->withPivot('visited_at')
                    ->withTimestamps();
    }
}
