<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Theme;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // Exemplo de livros, autores e temas já inseridos previamente pelos seeders correspondentes
        $books = [
            [
                'title' => 'Fundação',
                'synopsis' => 'Uma saga épica sobre o declínio e renascimento de um império galáctico.',
                'isbn' => '9788576572008',
                'year' => 1951,
                'language' => 'Português',
                'pages' => 544,
                'cover_url' => 'https://covers.openlibrary.org/b/id/11141565-L.jpg',
                'status' => 'published',
                'publisher_name' => 'Editora Aleph',
                'authors' => ['Isaac Asimov'],
                'themes' => ['Space Opera', 'Hard Sci-Fi'],
            ],
            [
                'title' => 'Androides Sonham com Ovelhas Elétricas?',
                'synopsis' => 'No futuro pós-apocalíptico, caçadores perseguem androides rebeldes.',
                'isbn' => '9788576572329',
                'year' => 1968,
                'language' => 'Português',
                'pages' => 368,
                'cover_url' => 'https://covers.openlibrary.org/b/id/11141567-L.jpg',
                'status' => 'published',
                'publisher_name' => 'Editora Aleph',
                'authors' => ['Philip K. Dick'],
                'themes' => ['Cyberpunk', 'Distopia'],
            ],
            [
                'title' => 'A Mão Esquerda da Escuridão',
                'synopsis' => 'Explora identidade de gênero em um planeta de clima extremo.',
                'isbn' => '9788576573906',
                'year' => 1969,
                'language' => 'Português',
                'pages' => 336,
                'cover_url' => 'https://covers.openlibrary.org/b/id/11141568-L.jpg',
                'status' => 'published',
                'publisher_name' => 'Editora Aleph',
                'authors' => ['Ursula K. Le Guin'],
                'themes' => ['Distopia'],
            ],
            [
                'title' => '2001: Uma Odisseia no Espaço',
                'synopsis' => 'Uma jornada épica pela evolução humana e inteligência artificial.',
                'isbn' => '9788535914849',
                'year' => 1968,
                'language' => 'Português',
                'pages' => 336,
                'cover_url' => 'https://covers.openlibrary.org/b/id/11141569-L.jpg',
                'status' => 'published',
                'publisher_name' => 'Editora Aleph',
                'authors' => ['Arthur C. Clarke'],
                'themes' => ['Space Opera', 'Hard Sci-Fi'],
            ],
        ];

        foreach ($books as $data) {
            $publisher = Publisher::where('name', $data['publisher_name'])->first();
            $book = Book::create([
                'title' => $data['title'],
                'synopsis' => $data['synopsis'],
                'isbn' => $data['isbn'],
                'year' => $data['year'],
                'language' => $data['language'],
                'pages' => $data['pages'],
                'cover_url' => $data['cover_url'],
                'status' => $data['status'],
                'publisher_id' => $publisher ? $publisher->id : null,
            ]);

            // Relaciona autores
            $authorIds = Author::whereIn('name', $data['authors'])->pluck('id');
            $book->authors()->sync($authorIds);

            // Relaciona temas
            $themeIds = Theme::whereIn('name', $data['themes'])->pluck('id');
            $book->themes()->sync($themeIds);
        }
    }
}