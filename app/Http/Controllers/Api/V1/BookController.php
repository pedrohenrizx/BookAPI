<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Theme;
use App\Http\Resources\BookResource;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    // Listagem de livros com filtros, busca, ordenação e paginação
    public function index(Request $request)
    {
        $query = Book::with(['authors', 'themes', 'publisher', 'reviews']);

        // Busca textual por título
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%$search%");
        }

        // Filtro por autor
        if ($request->has('author')) {
            $author = $request->input('author');
            $query->whereHas('authors', function ($q) use ($author) {
                $q->where('name', 'like', "%$author%");
            });
        }

        // Filtro por tema
        if ($request->has('theme')) {
            $theme = $request->input('theme');
            $query->whereHas('themes', function ($q) use ($theme) {
                $q->where('name', 'like', "%$theme%");
            });
        }

        // Filtro por editora
        if ($request->has('publisher')) {
            $publisher = $request->input('publisher');
            $query->whereHas('publisher', function ($q) use ($publisher) {
                $q->where('name', 'like', "%$publisher%");
            });
        }

        // Filtro por ano
        if ($request->has('year')) {
            $query->where('year', $request->input('year'));
        }

        // Filtro por idioma
        if ($request->has('language')) {
            $query->where('language', $request->input('language'));
        }

        // Ordenação
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $direction = 'asc';
            $field = $sort;
            if (str_starts_with($sort, '-')) {
                $direction = 'desc';
                $field = substr($sort, 1);
            }
            if (in_array($field, ['year', 'title', 'average_rating'])) {
                $query->orderBy($field, $direction);
            }
        } else {
            $query->orderBy('title', 'asc');
        }

        // Paginação
        $perPage = $request->input('per_page', 10);
        $books = $query->paginate($perPage);

        return BookResource::collection($books);
    }

    // Detalhe do livro
    public function show(Book $book)
    {
        $book->load(['authors', 'themes', 'publisher', 'reviews.user']);
        return new BookResource($book);
    }

    // Criar novo livro (admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'nullable|string',
            'isbn' => 'required|string|unique:books,isbn',
            'year' => 'required|integer',
            'language' => 'required|string|max:50',
            'pages' => 'required|integer|min:1',
            'cover_url' => 'nullable|url',
            'status' => ['required', Rule::in(['draft', 'published'])],
            'publisher_id' => 'required|exists:publishers,id',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:authors,id',
            'themes' => 'required|array|min:1',
            'themes.*' => 'exists:themes,id',
        ]);

        $book = Book::create($validated);
        $book->authors()->sync($validated['authors']);
        $book->themes()->sync($validated['themes']);
        $book->load(['authors', 'themes', 'publisher']);

        return new BookResource($book);
    }

    // Atualizar livro (admin)
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'synopsis' => 'nullable|string',
            'isbn' => [
                'sometimes', 'required', 'string',
                Rule::unique('books')->ignore($book->id)
            ],
            'year' => 'sometimes|required|integer',
            'language' => 'sometimes|required|string|max:50',
            'pages' => 'sometimes|required|integer|min:1',
            'cover_url' => 'nullable|url',
            'status' => ['sometimes', 'required', Rule::in(['draft', 'published'])],
            'publisher_id' => 'sometimes|required|exists:publishers,id',
            'authors' => 'sometimes|required|array|min:1',
            'authors.*' => 'exists:authors,id',
            'themes' => 'sometimes|required|array|min:1',
            'themes.*' => 'exists:themes,id',
        ]);

        $book->update($validated);

        if (array_key_exists('authors', $validated)) {
            $book->authors()->sync($validated['authors']);
        }
        if (array_key_exists('themes', $validated)) {
            $book->themes()->sync($validated['themes']);
        }

        $book->load(['authors', 'themes', 'publisher']);

        return new BookResource($book);
    }

    // Deletar livro (admin)
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(['message' => 'Livro deletado com sucesso.']);
    }

    // Adicionar autor ao livro (admin)
    public function attachAuthor(Request $request, Book $book)
    {
        $validated = $request->validate([
            'author_id' => 'required|exists:authors,id',
        ]);
        $book->authors()->syncWithoutDetaching($validated['author_id']);
        return response()->json(['message' => 'Autor adicionado ao livro.']);
    }

    // Remover autor do livro (admin)
    public function detachAuthor(Book $book, Author $author)
    {