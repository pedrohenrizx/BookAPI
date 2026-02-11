<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'rating',
        'comment',
    ];

    // Relação: Avaliação pertence a um livro
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Relação: Avaliação pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}