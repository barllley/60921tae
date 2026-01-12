<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ExhibitionControllerApi extends Controller
{
    /**
     * Display a listing of the resource with pagination
     */
    public function index(Request $request)
    {
        $perpage = $request->perpage ?? 5;
        $page = $request->page ?? 0;

        $exhibitions = Exhibition::with('tickets')
            ->limit($perpage)
            ->offset($perpage * $page)
            ->get();

        return response()->json($exhibitions);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Exhibition::with('tickets')->find($id));
    }

    /**
     * Get total count of exhibitions
     */
    public function total()
    {
        return response()->json([
            'total' => Exhibition::count()
        ]);
    }

    public function store(Request $request)
    {
        // 1. Проверка полномочий
        if (!Gate::allows('create-exhibition')) {
            return response()->json([
                'code' => 1,
                'message' => 'У вас нет прав на добавление выставки',
            ], 403);
        }

        // 2. Валидация
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'required|file',
        ]);

        // 3. Загрузка в S3
        $file = $request->file('image');
        $fileName = rand(1, 100000) . '_' . $file->getClientOriginalName();

        try {
            $path = Storage::disk('s3')->putFileAs('exhibitions', $file, $fileName);
            $fileUrl = Storage::disk('s3')->url($path);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 2,
                'message' => 'Ошибка загрузки файла в хранилище S3',
            ], 500);
        }

        // 4. Сохранение в БД
        $exhibition = new Exhibition($validated);
        $exhibition->image_url = $fileUrl;
        $exhibition->save();

        return response()->json([
            'code' => 0,
            'message' => 'Выставка успешно добавлена',
        ]);
    }
}
