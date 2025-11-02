<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Order;
use App\Models\TicketInstance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function show()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Для оформления заказа необходимо авторизоваться.');
        }

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста.');
        }

        $tickets = [];
        $total = 0;

        foreach ($cart as $ticketId => $item) {
            $ticket = Ticket::with('exhibition')->find($ticketId);
            if ($ticket && $ticket->available_quantity >= $item['quantity']) {
                $ticket->quantity = $item['quantity'];
                $ticket->subtotal = $ticket->price * $item['quantity'];
                $tickets[] = $ticket;
                $total += $ticket->subtotal;
            }
        }

        if (empty($tickets)) {
            return redirect()->route('cart.index')->with('error', 'Нет доступных билетов для покупки.');
        }

        return view('checkout.show', compact('tickets', 'total'));
    }

    public function process(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Для оформления заказа необходимо авторизоваться.');
        }

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста.');
        }

        // СОЗДАЕМ ЗАКАЗ БЕЗ ЛИШНИХ ДАННЫХ
        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        foreach ($cart as $ticketId => $item) {
            $ticket = Ticket::find($ticketId);

            if ($ticket && $ticket->available_quantity >= $item['quantity']) {
                for ($i = 0; $i < $item['quantity']; $i++) {
                    TicketInstance::create([
                        'ticket_id' => $ticket->id,
                        'order_id' => $order->id,
                        'qr_code' => $this->generateQrCode(),
                        'status' => 'valid',
                    ]);
                }

                $ticket->decrement('available_quantity', $item['quantity']);
            }
        }

        Session::forget('cart');

        return redirect()->route('checkout.success', $order)
            ->with('success', 'Заказ успешно оформлен!');
    }

    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return redirect('/')->with('error', 'Доступ запрещен.');
        }

        $order->load('ticketInstances.ticket.exhibition');

        return view('checkout.success', compact('order'));
    }

    private function generateQrCode()
    {
        return 'TICKET-' . strtoupper(uniqid());
    }
}
