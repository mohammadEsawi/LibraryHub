<?php

namespace App\Http\Controllers;

use App\Models\AuthorSubmission;
use App\Models\Book;
use App\Models\Category;
use App\Models\Purchase;
use Illuminate\Http\Request;

class AuthorSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $submissions = AuthorSubmission::with('category')
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10);

        $listedBooksCount = Book::where('listed_by_user_id', $userId)->count();

        $salesBaseQuery = Purchase::query()
            ->join('books', 'books.id', '=', 'purchases.book_id')
            ->where('books.listed_by_user_id', $userId);

        $totalEarnings = (float) (clone $salesBaseQuery)->sum('purchases.price_paid');
        $totalSales = (clone $salesBaseQuery)->count('purchases.id');
        $soldBooksCount = (clone $salesBaseQuery)->distinct()->count('purchases.book_id');

        $listedBooks = Book::with(['author', 'category'])
            ->where('listed_by_user_id', $userId)
            ->latest()
            ->take(8)
            ->get();

        return view('author-submissions.index', compact(
            'submissions',
            'listedBooksCount',
            'totalEarnings',
            'totalSales',
            'soldBooksCount',
            'listedBooks'
        ));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('author-submissions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'pages' => 'required|integer|min:1',
            'proposed_price' => 'required|numeric|min:0',
        ]);

        $validated['user_id'] = $request->user()->id;

        AuthorSubmission::create($validated);

        return redirect()->route('author-submissions.index')->with('success', 'تم إرسال طلب بيع الكتاب للإدارة.');
    }
}
