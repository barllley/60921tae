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
        'image_url',
    ];

     protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'exhibition_user')
                    ->withPivot('visited_at')
                    ->withTimestamps();
    }
}
