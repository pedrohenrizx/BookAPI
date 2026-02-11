<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            [
                'name' => 'Isaac Asimov',
                'bio' => 'Um dos mais prolíficos autores de ficção científica, criador da série Fundação.',
                'birthdate' => '1920-01-02',
                'nationality' => 'Russo-Americano',
            ],
            [
                'name' => 'Philip K. Dick',
                'bio' => 'Conhecido por obras que inspiraram filmes como Blade Runner e O Vingador do Futuro.',
                'birthdate' => '1928-12-16',
                'nationality' => 'Americano',
            ],
            [
                'name' => 'Ursula K. Le Guin',
                'bio' => 'Autora de O Feiticeiro de Terramar e A Mão Esquerda da Escuridão.',
                'birthdate' => '1929-10-21',
                'nationality' => 'Americana',
            ],
            [
                'name' => 'Arthur C. Clarke',
                'bio' => 'Autor de 2001: Uma Odisseia no Espaço.',
                'birthdate' => '1917-12-16',
                'nationality' => 'Britânico',
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}