<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Exhibition;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // Создаем выставки
    $exhibition1 = Exhibition::create([
        'title' => 'Выставка современного искусства',
        'description' => 'Уникальная коллекция современного искусства от российских и зарубежных художников.',
        'start_date' => '2024-10-01 10:00:00',
        'end_date' => '2024-12-01 20:00:00',
    ]);

    $exhibition2 = Exhibition::create([
        'title' => 'Исторические артефакты',
        'description' => 'Экспонаты из разных эпох, рассказывающие об истории человечества.',
        'start_date' => '2024-09-15 09:00:00',
        'end_date' => '2024-11-30 18:00:00',
    ]);

    // Создаем билеты для обеих выставок
    Ticket::create([
        'exhibition_id' => $exhibition1->id,
        'type' => 'standard',
        'price' => 500.00,
        'available_quantity' => 100,
    ]);

    Ticket::create([
        'exhibition_id' => $exhibition1->id,
        'type' => 'vip',
        'price' => 1500.00,
        'available_quantity' => 20,
    ]);

    Ticket::create([
        'exhibition_id' => $exhibition2->id,
        'type' => 'standard',
        'price' => 400.00,
        'available_quantity' => 80,
    ]);

    Ticket::create([
        'exhibition_id' => $exhibition2->id,
        'type' => 'child',
        'price' => 200.00,
        'available_quantity' => 50,
    ]);

    // Создаем пользователей
    $user1 = User::create([
        'name' => 'Иван Иванов',
        'email' => 'ivan@example.com',
        'password' => bcrypt('password'),
    ]);

    $user2 = User::create([
        'name' => 'Мария Петрова',
        'email' => 'maria@example.com',
        'password' => bcrypt('password'),
    ]);

    // Создаем отношения многие-ко-многим
    $user1->exhibitions()->attach($exhibition1->id, ['visited_at' => now()]);
    $user1->exhibitions()->attach($exhibition2->id, ['visited_at' => now()->subDays(5)]);
    $user2->exhibitions()->attach($exhibition1->id, ['visited_at' => now()->subDays(2)]);
}
}
