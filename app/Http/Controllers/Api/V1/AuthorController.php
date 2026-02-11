<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Http\Resources\AuthorResource;
use Illuminate\Validation\Rule;

class AuthorController extends Controller
{
    // Listar autores
    public function index(Request $request)
    {
        $query = Author::query();

        // Filtro por nome
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $authors = $query->orderBy('name')->paginate($request->input('per_page', 10));
        return AuthorResource::collection($authors);
    }

    // Detalhes de um autor
    public function show(Author $author)
    {
        $author->load('books');
        return new AuthorResource($author);
    }

    // Criar autor (admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'birthdate' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
        ]);
        $author = Author::create($validated);
        return new AuthorResource($author);
    }

    // Atualizar autor (admin)
    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'bio' => 'nullable|string',
            'birthdate' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
        ]);
        $author->update($validated);
        return new AuthorResource($author);
    }

    // Deletar autor (admin)
    public function destroy(Author $author)
    {
        $author->delete();
        return response()->json(['message' => 'Autor deletado com sucesso.']);
    }
}