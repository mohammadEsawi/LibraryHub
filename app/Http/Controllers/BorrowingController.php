<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function borrow(Request $request, Book $book)
    {
        if (!$book->available) {
            return back()->with('error', 'الكتاب غير متاح حالياً.');
        }

        Borrowing::create([
            'book_id' => $book->id,
            'user_id' => Auth::id(),
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14), // استعارة لمدة أسبوعين
        ]);

        $book->update(['available' => false]);

        return back()->with('success', 'تمت استعارة الكتاب بنجاح!');
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->returned_at) {
            return back()->with('error', 'هذه الإعارة تم إرجاعها مسبقاً.');
        }

        $borrowing->update([
            'returned_at' => now(),
        ]);

        $borrowing->book->update(['available' => true]);

        return back()->with('success', 'تم إرجاع الكتاب، شكراً لك!');
    }
}