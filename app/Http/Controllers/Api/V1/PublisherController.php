<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publisher;
use App\Http\Resources\PublisherResource;

class PublisherController extends Controller
{
    // Listar editoras
    public function index(Request $request)
    {
        $query = Publisher::query();

        // Filtro por nome
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $publishers = $query->orderBy('name')->paginate($request->input('per_page', 10));
        return PublisherResource::collection($publishers);
    }

    // Detalhes de uma editora
    public function show(Publisher $publisher)
    {
        $publisher->load('books');
        return new PublisherResource($publisher);
    }

    // Criar editora (admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
        ]);
        $publisher = Publisher::create($validated);
        return new PublisherResource($publisher);
    }

    // Atualizar editora (admin)
    public function update(Request $request, Publisher $publisher)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'country' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
        ]);
        $publisher->update($validated);
        return new PublisherResource($publisher);
    }

    // Deletar editora (admin)
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return response()->json(['message' => 'Editora deletada com sucesso.']);
    }
}