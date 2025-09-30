<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Отношение многие-ко-многим с пользователями
    public function users()
    {
        return $this->belongsToMany(User::class, 'exhibition_user')
                    ->withPivot('visited_at')
                    ->withTimestamps();
    }

}
