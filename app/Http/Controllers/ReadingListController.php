<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ReadingList;
use Illuminate\Http\Request;

class ReadingListController extends Controller
{
    public function index(Request $request)
    {
        $entries = ReadingList::with(['book.author', 'book.category'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(12);

        return view('reading-list.index', compact('entries'));
    }

    public function store(Request $request, Book $book)
    {
        $entry = ReadingList::firstOrCreate(
            [
                'user_id' => $request->user()->id,
                'book_id' => $book->id,
            ],
            [
                'started_at' => now(),
            ]
        );

        if (!$entry->wasRecentlyCreated) {
            return back()->with('error', 'الكتاب موجود مسبقاً في قائمة القراءة.');
        }

        return back()->with('success', 'تمت إضافة الكتاب إلى قائمة القراءة.');
    }
}
