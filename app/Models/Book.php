<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'isbn',
        'image',
        'quantity',
        'status',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}
