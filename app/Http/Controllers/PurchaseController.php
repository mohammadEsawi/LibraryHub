<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function store(Request $request, Book $book)
    {
        if (!$book->available) {
            return back()->with('error', 'هذا الكتاب غير متاح حالياً.');
        }

        $alreadyBought = Purchase::where('user_id', $request->user()->id)
            ->where('book_id', $book->id)
            ->exists();

        if ($alreadyBought) {
            return back()->with('error', 'أنت اشتريت هذا الكتاب مسبقاً.');
        }

        Purchase::create([
            'user_id' => $request->user()->id,
            'book_id' => $book->id,
            'price_paid' => $book->price,
            'purchased_at' => now(),
        ]);

        return back()->with('success', 'تم شراء الكتاب بنجاح.');
    }
}
