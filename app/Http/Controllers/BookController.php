<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        // with() يحمّل العلاقات بكفاءة — بدونه راح تصير N+1
        $books = Book::with(['author', 'category'])
                     ->latest()
                     ->paginate(10);

        return view('books.index', compact('books'));
    }

    public function create()
    {
        // نحتاج قوائم الكتّاب والتصنيفات للـ dropdowns
        $authors    = Author::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('books.create', compact('authors', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'author_id'      => 'required|exists:authors,id',
            'category_id'    => 'required|exists:categories,id',
            'published_year' => 'required|integer|min:1000|max:' . date('Y'),
            'pages'          => 'required|integer|min:1',
            'available'      => 'boolean',
        ]);

        $validated['available'] = $request->has('available');

        Book::create($validated);

        return redirect()->route('books.index')
                         ->with('success', 'تمت إضافة الكتاب بنجاح!');
    }

    public function show(Book $book)
    {
        // load() يحمّل العلاقة على سجل واحد موجود
        $book->load(['author', 'category']);

        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors    = Author::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'author_id'      => 'required|exists:authors,id',
            'category_id'    => 'required|exists:categories,id',
            'published_year' => 'required|integer|min:1000|max:' . date('Y'),
            'pages'          => 'required|integer|min:1',
            'available'      => 'boolean',
        ]);

        $validated['available'] = $request->has('available');

        $book->update($validated);

        return redirect()->route('books.index')
                         ->with('success', 'تم تعديل الكتاب بنجاح!');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
                         ->with('success', 'تم حذف الكتاب!');
    }
}