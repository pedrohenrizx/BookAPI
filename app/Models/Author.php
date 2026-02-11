<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'birthdate',
        'nationality',
    ];

    // Relação: Autor tem muitos livros (N:N)
    public function books()
    {
        return $this->belongsToMany(Book::class)->withTimestamps();
    }
}