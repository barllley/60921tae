<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Order;
use App\Models\TicketInstance;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutControllerApi extends Controller
{
    public function show()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Для оформления заказа необходимо авторизоваться.'
            ], 401);
        }

        $user = Auth::user();
        $cartItems = CartItem::with('ticket.exhibition')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Корзина пуста.'
            ], 400);
        }

        $availableItems = [];
        $total = 0;

        foreach ($cartItems as $cartItem) {
            $ticket = $cartItem->ticket;
            if ($ticket && $ticket->available_quantity >= $cartItem->quantity) {
                $ticket->quantity = $cartItem->quantity;
                $ticket->subtotal = $ticket->price * $cartItem->quantity;
                $availableItems[] = $ticket;
                $total += $ticket->subtotal;
            }
        }

        if (empty($availableItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Нет доступных билетов для покупки.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'tickets' => $availableItems,
                'total' => $total
            ]
        ]);
    }

    public function process(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Для оформления заказа необходимо авторизоваться.'
            ], 401);
        }

        $user = Auth::user();
        $cartItems = CartItem::with('ticket')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Корзина пуста.'
            ], 400);
        }

        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        $processedItems = [];

        foreach ($cartItems as $cartItem) {
            $ticket = $cartItem->ticket;

            if ($ticket && $ticket->available_quantity >= $cartItem->quantity) {
                for ($i = 0; $i < $cartItem->quantity; $i++) {
                    TicketInstance::create([
                        'ticket_id' => $ticket->id,
                        'order_id' => $order->id,
                        'qr_code' => $this->generateQrCode(),
                        'status' => 'valid',
                    ]);
                }

                $ticket->decrement('available_quantity', $cartItem->quantity);

                $processedItems[] = [
                    'ticket_id' => $ticket->id,
                    'ticket_type' => $ticket->type,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $ticket->price * $cartItem->quantity
                ];
            }
        }

        CartItem::where('user_id', $user->id)->delete();

        $order->load('ticketInstances.ticket');

        return response()->json([
            'success' => true,
            'message' => 'Заказ успешно оформлен!',
            'data' => [
                'order_id' => $order->id,
                'order_status' => $order->status,
                'processed_items' => $processedItems,
                'ticket_instances' => $order->ticketInstances
            ]
        ]);
    }

    private function generateQrCode()
    {
        return 'TICKET-' . strtoupper(uniqid());
    }
}
