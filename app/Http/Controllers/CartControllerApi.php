<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartControllerApi extends Controller
{
    private function getCartIdentifier()
    {

        $token = request()->bearerToken();

        if ($token) {
            try {
                if (str_contains($token, '|')) {
                    [$id, $token] = explode('|', $token, 2);
                }

                $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);

                if ($accessToken) {
                    $user = $accessToken->tokenable;
                    if ($user) {
                        Auth::setUser($user);
                        return [
                            'value' => $user->id,
                            'type' => 'user_id',
                            'is_authenticated' => true
                        ];
                    }
                }
            } catch (\Exception $e) {
                // Если ошибка парсинга токена - игнорируем
            }
        }

        return [
            'value' => session()->getId(),
            'type' => 'session_id',
            'is_authenticated' => false
        ];
    }

    private function cartQuery($identifier)
    {
        return $identifier['type'] === 'user_id'
            ? CartItem::where('user_id', $identifier['value'])
            : CartItem::where('session_id', $identifier['value']);
    }

    private function getCartCount($identifier)
    {
        return $this->cartQuery($identifier)->count();
    }

    public function index()
    {
        $identifier = $this->getCartIdentifier();
        $cartItems = $this->cartQuery($identifier)->with('ticket.exhibition')->get();

        $total = $cartItems->sum(fn($item) => $item->ticket->price * $item->quantity);

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $cartItems,
                'total' => $total,
                'cart_count' => $cartItems->count(),
                'is_authenticated' => $identifier['is_authenticated']
            ]
        ]);
    }

    public function add(Request $request, $ticketId)
    {
        $identifier = $this->getCartIdentifier();
        $ticket = Ticket::find($ticketId);

        if (!$ticket) {
            return response()->json(['success' => false, 'message' => 'Билет не найден'], 404);
        }

        $quantity = $request->input('quantity', 1);

        if ($ticket->available_quantity < $quantity) {
            return response()->json(['success' => false, 'message' => 'Недостаточно билетов в наличии.'], 400);
        }

        $cartItem = $this->cartQuery($identifier)
            ->where('ticket_id', $ticketId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            CartItem::create([
                'user_id' => $identifier['type'] === 'user_id' ? $identifier['value'] : null,
                'session_id' => $identifier['type'] === 'session_id' ? $identifier['value'] : null,
                'ticket_id' => $ticketId,
                'quantity' => $quantity
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Билет добавлен в корзину!',
            'cart_count' => $this->getCartCount($identifier),
            'is_authenticated' => $identifier['is_authenticated']
        ]);
    }

    public function remove($ticketId)
    {
        $identifier = $this->getCartIdentifier();

        $cartItem = $this->cartQuery($identifier)
            ->where('ticket_id', $ticketId)
            ->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Билет не найден в корзине'], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Билет удален из корзины.',
            'cart_count' => $this->getCartCount($identifier),
            'is_authenticated' => $identifier['is_authenticated']
        ]);
    }

    public function update(Request $request, $ticketId)
    {
        $quantity = $request->input('quantity', 1);

        if ($quantity <= 0) {
            return $this->remove($ticketId);
        }

        $identifier = $this->getCartIdentifier();
        $ticket = Ticket::find($ticketId);

        if (!$ticket) {
            return response()->json(['success' => false, 'message' => 'Билет не найден'], 404);
        }

        if ($ticket->available_quantity < $quantity) {
            return response()->json(['success' => false, 'message' => 'Недостаточно билетов в наличии.'], 400);
        }

        $cartItem = $this->cartQuery($identifier)
            ->where('ticket_id', $ticketId)
            ->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $quantity]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Количество обновлено.',
            'cart_count' => $this->getCartCount($identifier),
            'is_authenticated' => $identifier['is_authenticated']
        ]);
    }

    public function clear()
    {
        $identifier = $this->getCartIdentifier();
        $this->cartQuery($identifier)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Корзина очищена.',
            'cart_count' => 0,
            'is_authenticated' => $identifier['is_authenticated']
        ]);
    }
}
