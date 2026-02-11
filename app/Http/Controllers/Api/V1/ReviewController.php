<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Review;
use App\Http\Resources\ReviewResource;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Listar avaliações de um livro
    public function index(Book $book)
    {
        $reviews = $book->reviews()->with('user')->orderBy('created_at', 'desc')->paginate(10);
        return ReviewResource::collection($reviews);
    }

    // Criar avaliação (usuário autenticado)
    public function store(Request $request, Book $book)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        // Previne múltiplas avaliações do mesmo usuário para o mesmo livro
        if ($book->reviews()->where('user_id', Auth::id())->exists()) {
            return response()->json(['message' => 'Você já avaliou este livro.'], 409);
        }

        $review = $book->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        // Atualiza média de avaliações do livro
        $book->average_rating = round($book->reviews()->avg('rating'), 2);
        $book->save();

        return new ReviewResource($review->load('user'));
    }
}