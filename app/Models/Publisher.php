<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'website',
    ];

    // Relação: Editora possui muitos livros (1:N)
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}