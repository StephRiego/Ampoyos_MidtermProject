<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;

class Book extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'title',
        'author',
        'published_year',
        'genre',
        'category_id',
    ];

    // Inverse relationship: Book belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
