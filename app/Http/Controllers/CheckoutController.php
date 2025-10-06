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
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста.');
        }

        // Валидация
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
        ]);

        // Создаем заказ
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => 0, // Рассчитаем ниже
            'status' => 'pending',
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
        ]);

        $totalAmount = 0;

        // Обрабатываем каждый билет в корзине
        foreach ($cart as $ticketId => $item) {
            $ticket = Ticket::find($ticketId);

            if ($ticket && $ticket->available_quantity >= $item['quantity']) {
                // Создаем экземпляры билетов
                for ($i = 0; $i < $item['quantity']; $i++) {
                    TicketInstance::create([
                        'ticket_id' => $ticket->id,
                        'order_id' => $order->id,
                        'status' => 'active',
                        'unique_code' => $this->generateUniqueCode(),
                    ]);
                }

                // Обновляем доступное количество
                $ticket->decrement('available_quantity', $item['quantity']);

                $totalAmount += $ticket->price * $item['quantity'];
            }
        }

        // Обновляем общую сумму заказа
        $order->update(['total_amount' => $totalAmount]);

        // Очищаем корзину
        Session::forget('cart');

        return redirect()->route('checkout.success', $order)
            ->with('success', 'Заказ успешно оформлен!');
    }

    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }

    private function generateUniqueCode()
    {
        return 'SAT-' . strtoupper(uniqid());
    }
}
