<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Purchase;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show(Request $request, Book $book)
    {
        if (!$book->available) {
            return redirect()->route('books.show', $book)->with('error', 'هذا الكتاب غير متاح حالياً.');
        }

        $alreadyBought = Purchase::where('user_id', $request->user()->id)
            ->where('book_id', $book->id)
            ->exists();

        if ($alreadyBought) {
            return redirect()->route('books.show', $book)->with('error', 'أنت اشتريت هذا الكتاب مسبقاً.');
        }

        return view('checkout.show', compact('book'));
    }

    public function process(Request $request, Book $book)
    {
        // التحقق من الشروط نفسها
        if (!$book->available) {
            return back()->with('error', 'هذا الكتاب غير متاح حالياً.');
        }

        $alreadyBought = Purchase::where('user_id', $request->user()->id)
            ->where('book_id', $book->id)
            ->exists();

        if ($alreadyBought) {
            return back()->with('error', 'أنت اشتريت هذا الكتاب مسبقاً.');
        }

        // إنشاء عملية شراء
        Purchase::create([
            'user_id' => $request->user()->id,
            'book_id' => $book->id,
            'price_paid' => $book->price,
            'purchased_at' => now(),
        ]);

        return redirect()->route('books.show', $book)->with('success', 'تم شراء الكتاب بنجاح! ✓');
    }
}
