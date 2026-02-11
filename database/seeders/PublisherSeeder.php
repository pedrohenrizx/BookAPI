<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;

class PublisherSeeder extends Seeder
{
    public function run(): void
    {
        $publishers = [
            [
                'name' => 'Editora Aleph',
                'country' => 'Brasil',
                'website' => 'https://www.editoraaleph.com.br',
            ],
            [
                'name' => 'Tor Books',
                'country' => 'Estados Unidos',
                'website' => 'https://www.tor.com',
            ],
            [
                'name' => 'Gollancz',
                'country' => 'Reino Unido',
                'website' => 'https://www.gollancz.co.uk',
            ],
            [
                'name' => 'Del Rey',
                'country' => 'Estados Unidos',
                'website' => 'https://www.penguinrandomhouse.com/imprints/del-rey/',
            ],
        ];

        foreach ($publishers as $publisher) {
            Publisher::create($publisher);
        }
    }
}