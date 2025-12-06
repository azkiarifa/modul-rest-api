<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // jika nama tabel bukan 'books', set di sini:
    // protected $table = 'books';

    // mass assignable fields (sesuaikan)
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'year',
        'description',
    ];
}
