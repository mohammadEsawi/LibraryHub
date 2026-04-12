<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'published_year',
        'pages',
        'published',
        'available',
        'price',
        'listed_by_user_id',
    ];

    protected $casts = [
        'available' => 'boolean',
        'published' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function readingListEntries()
    {
        return $this->hasMany(ReadingList::class);
    }

    public function listedBy()
    {
        return $this->belongsTo(User::class, 'listed_by_user_id');
    }
}
