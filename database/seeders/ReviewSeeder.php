<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Book;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@scifi.com')->first();
        $admin = User::where('email', 'admin@scifi.com')->first();

        $books = Book::all();

        // Cada usuário avalia todos os livros com notas diferentes
        $rating = 5;
        foreach ($books as $book) {
            Review::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'rating' => $rating,
                'comment' => 'Ótimo livro de sci-fi!',
            ]);
            $rating = $rating > 1 ? $rating - 1 : 5; // notas de 5 a 2

            Review::create([
                'user_id' => $admin->id,
                'book_id' => $book->id,
                'rating' => rand(3, 5),
                'comment' => 'Leitura clássica.',
            ]);
        }
    }
}