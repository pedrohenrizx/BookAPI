<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Theme;
use App\Http\Resources\ThemeResource;

class ThemeController extends Controller
{
    // Listar temas/categorias
    public function index(Request $request)
    {
        $query = Theme::query();

        // Filtro por nome
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $themes = $query->orderBy('name')->paginate($request->input('per_page', 10));
        return ThemeResource::collection($themes);
    }

    // Detalhes de um tema
    public function show(Theme $theme)
    {
        $theme->load('books');
        return new ThemeResource($theme);
    }

    // Criar tema (admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $theme = Theme::create($validated);
        return new ThemeResource($theme);
    }

    // Atualizar tema (admin)
    public function update(Request $request, Theme $theme)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $theme->update($validated);
        return new ThemeResource($theme);
    }

    // Deletar tema (admin)
    public function destroy(Theme $theme)
    {
        $theme->delete();
        return response()->json(['message' => 'Tema deletado com sucesso.']);
    }
}