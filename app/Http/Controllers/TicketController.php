<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Exhibition;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 5);
        $tickets = Ticket::with('exhibition')->paginate($perPage)->withQueryString();
        return view('tickets.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = Ticket::with('exhibition')->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    public function create()
    {
        if (!Gate::allows('manage-tickets')) {
            return redirect()->route('tickets.index')
                ->with('error', 'У вас нет прав для создания билетов. Только администратор может создавать билеты.');
        }

        $exhibitions = Exhibition::all();
        return view('tickets.create', compact('exhibitions'));
    }

    public function store(Request $request)
    {
        if (!Gate::allows('manage-tickets')) {
            return redirect()->route('tickets.index')
                ->with('error', 'У вас нет прав для создания билетов. Только администратор может создавать билеты.');
        }

        try {
            $validated = $request->validate([
                'exhibition_id' => 'required|exists:exhibitions,id',
                'type' => ['required', Rule::in(['standard', 'vip', 'child'])],
                'price' => 'required|numeric|min:0',
                'available_quantity' => 'required|integer|min:1',
            ], [
                'exhibition_id.required' => 'Поле выставка обязательно для заполнения.',
                'exhibition_id.exists' => 'Выбранная выставка не существует.',
                'type.required' => 'Поле тип билета обязательно для заполнения.',
                'type.in' => 'Выбранный тип билета недопустим.',
                'price.required' => 'Поле цена обязательно для заполнения.',
                'price.numeric' => 'Цена должна быть числом.',
                'price.min' => 'Цена не может быть отрицательной.',
                'available_quantity.required' => 'Поле доступное количество обязательно для заполнения.',
                'available_quantity.integer' => 'Доступное количество должно быть целым числом.',
                'available_quantity.min' => 'Доступное количество должно быть не менее 1.',
            ]);

            Ticket::create($validated);

            return redirect()->route('tickets.index')
                ->with('success', 'Билет успешно создан!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Произошла ошибка при создании билета: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('manage-tickets')) {
            return redirect()->route('tickets.index')
                ->with('error', 'У вас нет прав для редактирования билетов. Только администратор может редактировать билеты.');
        }

        try {
            $ticket = Ticket::findOrFail($id);
            $exhibitions = Exhibition::all();
            return view('tickets.edit', compact('ticket', 'exhibitions'));

        } catch (\Exception $e) {
            return redirect()->route('tickets.index')
                ->with('error', 'Билет не найден.');
        }
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('manage-tickets')) {
            return redirect()->route('tickets.index')
                ->with('error', 'У вас нет прав для редактирования билетов. Только администратор может редактировать билеты.');
        }

        try {
            $ticket = Ticket::findOrFail($id);

            $validated = $request->validate([
                'exhibition_id' => 'required|exists:exhibitions,id',
                'type' => ['required', Rule::in(['standard', 'vip', 'child'])],
                'price' => 'required|numeric|min:0',
                'available_quantity' => 'required|integer|min:0',
            ], [
                'exhibition_id.required' => 'Поле выставка обязательно для заполнения.',
                'exhibition_id.exists' => 'Выбранная выставка не существует.',
                'type.required' => 'Поле тип билета обязательно для заполнения.',
                'type.in' => 'Выбранный тип билета недопустим.',
                'price.required' => 'Поле цена обязательно для заполнения.',
                'price.numeric' => 'Цена должна быть числом.',
                'price.min' => 'Цена не может быть отрицательной.',
                'available_quantity.required' => 'Поле доступное количество обязательно для заполнения.',
                'available_quantity.integer' => 'Доступное количество должно быть целым числом.',
                'available_quantity.min' => 'Доступное количество не может быть отрицательным.',
            ]);

            $ticket->update($validated);

            return redirect()->route('tickets.index')
                ->with('success', 'Билет успешно обновлен!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Произошла ошибка при обновлении билета: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('manage-tickets')) {
            return redirect()->route('tickets.index')
                ->with('error', 'У вас нет прав для удаления билетов. Только администратор может удалять билеты.');
        }

        try {
            $ticket = Ticket::findOrFail($id);
            $ticketName = "Билет #{$ticket->id} ({$ticket->type})";
            $ticket->delete();

            return redirect()->route('tickets.index')
                ->with('success', "Билет '{$ticketName}' успешно удален!");

        } catch (\Exception $e) {
            return redirect()->route('tickets.index')
                ->with('error', 'Произошла ошибка при удалении билета: ' . $e->getMessage());
        }
    }
}
