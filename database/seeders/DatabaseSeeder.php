<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Exhibition;
use App\Models\Ticket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $exhibition1 = Exhibition::create([
            'title' => 'Выставка современного искусства',
            'description' => 'Уникальная коллекция современного искусства от российских и зарубежных художников.',
            'start_date' => '2024-10-01 10:00:00',
            'end_date' => '2024-12-01 20:00:00',
        ]);

        $exhibition2 = Exhibition::create([
            'title' => 'Исторические артефакты',
            'description' => 'Экспонаты из разных эпох, рассказывающие об истории человечества.',
            'start_date' => '2024-09-15',
            'end_date' => '2024-11-30',
        ]);

        $exhibition3 = Exhibition::create([
            'title' => 'Научные открытия',
            'description' => 'Интерактивная выставка о последних научных достижениях.',
            'start_date' => '2024-11-01',
            'end_date' => '2025-01-15',
        ]);

        $user1 = User::create([
            'name' => 'Иван Иванов',
            'email' => 'ivan@example.com',
            'password' => Hash::make('password'),
        ]);

        $user2 = User::create([
            'name' => 'Мария Петрова',
            'email' => 'maria@example.com',
            'password' => Hash::make('password'),
        ]);

        $user3 = User::create([
            'name' => 'Алексей Сидоров',
            'email' => 'alexey@example.com',
            'password' => Hash::make('password'),
        ]);


        $admin = User::create([
            'name' => 'Администратор',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'is_admin' => 1,
        ]);

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


        $ticketTypes = ['standard', 'vip', 'child'];
        $exhibitionIds = [$exhibition1->id, $exhibition2->id, $exhibition3->id];

        for ($i = 1; $i <= 15; $i++) {
            $exhibitionId = $exhibitionIds[array_rand($exhibitionIds)];
            $type = $ticketTypes[array_rand($ticketTypes)];
            $price = [300, 400, 500, 600, 800, 1000, 1200, 1500, 2000][array_rand([300, 400, 500, 600, 800, 1000, 1200, 1500, 2000])];

            Ticket::create([
                'exhibition_id' => $exhibitionId,
                'type' => $type,
                'price' => $price,
                'available_quantity' => rand(10, 100),
            ]);
        }

        // отношения многие-ко-многим
        $user1->exhibitions()->attach($exhibition1->id, ['visited_at' => now()]);
        $user1->exhibitions()->attach($exhibition2->id, ['visited_at' => now()->subDays(5)]);
        $user1->exhibitions()->attach($exhibition3->id, ['visited_at' => now()->subDays(3)]);

        $user2->exhibitions()->attach($exhibition1->id, ['visited_at' => now()->subDays(2)]);
        $user2->exhibitions()->attach($exhibition3->id, ['visited_at' => now()->subDays(1)]);

        $user3->exhibitions()->attach($exhibition2->id, ['visited_at' => now()->subDays(4)]);
        $user3->exhibitions()->attach($exhibition3->id, ['visited_at' => now()]);
    }
}
