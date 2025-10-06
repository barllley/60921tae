<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $tickets = [];
        $total = 0;

        foreach ($cart as $ticketId => $item) {
            $ticket = Ticket::with('exhibition')->find($ticketId);
            if ($ticket) {
                $ticket->quantity = $item['quantity'];
                $ticket->subtotal = $ticket->price * $item['quantity'];
                $tickets[] = $ticket;
                $total += $ticket->subtotal;
            }
        }

        return view('cart.index', compact('tickets', 'total'));
    }

    public function add(Request $request, Ticket $ticket)
    {
        $cart = Session::get('cart', []);
        $quantity = $request->input('quantity', 1);

        // Проверяем доступность
        if ($ticket->available_quantity < $quantity) {
            return back()->with('error', 'Недостаточно билетов в наличии.');
        }

        // Добавляем в корзину
        if (isset($cart[$ticket->id])) {
            $cart[$ticket->id]['quantity'] += $quantity;
        } else {
            $cart[$ticket->id] = [
                'quantity' => $quantity,
                'added_at' => now()
            ];
        }

        Session::put('cart', $cart);

        return back()->with('success', 'Билет добавлен в корзину!');
    }

    public function remove(Ticket $ticket)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$ticket->id])) {
            unset($cart[$ticket->id]);
            Session::put('cart', $cart);
        }

        return back()->with('success', 'Билет удален из корзины.');
    }

    public function update(Request $request, Ticket $ticket)
    {
        $cart = Session::get('cart', []);
        $quantity = $request->input('quantity', 1);

        if ($quantity <= 0) {
            return $this->remove($ticket);
        }

        // Проверяем доступность
        if ($ticket->available_quantity < $quantity) {
            return back()->with('error', 'Недостаточно билетов в наличии.');
        }

        if (isset($cart[$ticket->id])) {
            $cart[$ticket->id]['quantity'] = $quantity;
            Session::put('cart', $cart);
        }

        return back()->with('success', 'Количество обновлено.');
    }

    public function clear()
    {
        Session::forget('cart');
        return back()->with('success', 'Корзина очищена.');
    }
}
