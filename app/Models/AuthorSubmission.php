<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'published_year',
        'pages',
        'proposed_price',
        'status',
        'admin_note',
        'approved_book_id',
    ];

    protected $casts = [
        'proposed_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function approvedBook()
    {
        return $this->belongsTo(Book::class, 'approved_book_id');
    }
}
