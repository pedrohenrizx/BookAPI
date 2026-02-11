<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theme;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $themes = [
            [
                'name' => 'Space Opera',
                'description' => 'Aventuras épicas e interplanetárias com tecnologia avançada e conflitos galácticos.'
            ],
            [
                'name' => 'Cyberpunk',
                'description' => 'Ficção científica ambientada em sociedades distópicas, alta tecnologia e baixo padrão de vida.'
            ],
            [
                'name' => 'Distopia',
                'description' => 'Sociedades futuristas opressoras e decadentes.'
            ],
            [
                'name' => 'Viagem no Tempo',
                'description' => 'Explora paradoxos e consequências de viajar através do tempo.'
            ],
            [
                'name' => 'Hard Sci-Fi',
                'description' => 'Enfatiza rigor científico e plausibilidade nas premissas tecnológicas.'
            ],
        ];

        foreach ($themes as $theme) {
            Theme::create($theme);
        }
    }
}