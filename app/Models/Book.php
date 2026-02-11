<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'synopsis',
        'isbn',
        'year',
        'language',
        'pages',
        'cover_url',
        'status',
        'average_rating',
        'publisher_id',
    ];

    // Relação: Livro pertence a uma editora
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    // Relação: Livro tem muitos autores (N:N)
    public function authors()
    {
        return $this->belongsToMany(Author::class)->withTimestamps();
    }

    // Relação: Livro tem muitos temas (N:N)
    public function themes()
    {
        return $this->belongsToMany(Theme::class)->withTimestamps();
    }

    // Relação: Livro tem muitas avaliações
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}