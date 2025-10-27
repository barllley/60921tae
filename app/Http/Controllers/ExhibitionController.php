<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ExhibitionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 5);
        $exhibitions = Exhibition::with('tickets')
                                 ->paginate($perPage)
                                 ->withQueryString();

        return view('exhibitions.index', compact('exhibitions'));
    }

    public function show($id)
    {
        $exhibition = Exhibition::with('tickets')->findOrFail($id);
        return view('exhibitions.show', compact('exhibition'));
    }

    public function create()
    {
        if (!Gate::allows('manage-exhibitions')) {
            return redirect()->route('exhibitions.index')
                ->with('error', 'У вас нет прав для создания выставок.');
        }

        return view('exhibitions.create');
    }

    public function store(Request $request)
    {
        if (!Gate::allows('manage-exhibitions')) {
            return redirect()->route('exhibitions.index')
                ->with('error', 'У вас нет прав для создания выставок.');
        }

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            Exhibition::create($validated);

            return redirect()->route('exhibitions.index')
                ->with('success', 'Выставка успешно создана!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Произошла ошибка при создании выставки: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        if (!Gate::allows('manage-exhibitions')) {
            return redirect()->route('exhibitions.index')
                ->with('error', 'У вас нет прав для редактирования выставок.');
        }

        try {
            $exhibition = Exhibition::findOrFail($id);
            return view('exhibitions.edit', compact('exhibition'));

        } catch (\Exception $e) {
            return redirect()->route('exhibitions.index')
                ->with('error', 'Выставка не найдена.');
        }
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('manage-exhibitions')) {
            return redirect()->route('exhibitions.index')
                ->with('error', 'У вас нет прав для редактирования выставок.');
        }

        try {
            $exhibition = Exhibition::findOrFail($id);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $exhibition->update($validated);

            return redirect()->route('exhibitions.index')
                ->with('success', 'Выставка успешно обновлена!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Произошла ошибка при обновлении выставки: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        if (!Gate::allows('manage-exhibitions')) {
            return redirect()->route('exhibitions.index')
                ->with('error', 'У вас нет прав для удаления выставок.');
        }

        try {
            $exhibition = Exhibition::findOrFail($id);
            $exhibitionTitle = $exhibition->title;
            $exhibition->delete();

            return redirect()->route('exhibitions.index')
                ->with('success', "Выставка '{$exhibitionTitle}' успешно удалена!");

        } catch (\Exception $e) {
            return redirect()->route('exhibitions.index')
                ->with('error', 'Произошла ошибка при удалении выставки: ' . $e->getMessage());
        }
    }
}
