<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Exhibition;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('exhibition')->get();
        return view('tickets.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = Ticket::with('exhibition')->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    // Показ формы создания
    public function create()
    {
        $exhibitions = Exhibition::all();
        return view('tickets.create', compact('exhibitions'));
    }

    // Сохранение нового билета
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exhibition_id' => 'required|exists:exhibitions,id',
            'type' => ['required', Rule::in(['standard', 'vip', 'child'])],
            'price' => 'required|numeric|min:0',
            'available_quantity' => 'required|integer|min:1',
        ]);

        Ticket::create($validated);

        return redirect()->route('tickets.index')
                         ->with('success', 'Билет успешно создан!');
    }

    // Показ формы редактирования
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $exhibitions = Exhibition::all();
        return view('tickets.edit', compact('ticket', 'exhibitions'));
    }

    // Обновление билета
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'exhibition_id' => 'required|exists:exhibitions,id',
            'type' => ['required', Rule::in(['standard', 'vip', 'child'])],
            'price' => 'required|numeric|min:0',
            'available_quantity' => 'required|integer|min:0',
        ]);

        $ticket->update($validated);

        return redirect()->route('tickets.index')
                         ->with('success', 'Билет успешно обновлен!');
    }

    // Удаление билета
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('tickets.index')
                         ->with('success', 'Билет успешно удален!');
    }
}
