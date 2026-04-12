<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'category', 'listedBy'])
                     ->latest()
                     ->paginate(10);

        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors    = Author::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('books.create', compact('authors', 'categories'));
    }

    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();
        $validated['available'] = $request->boolean('available');
        $validated['published'] = true;
        $validated['listed_by_user_id'] = $request->user()?->id;

        $book = Book::create($validated);

        ActivityLog::create([
            'admin_user_id' => $request->user()->id,
            'action' => 'create_book',
            'entity_type' => Book::class,
            'entity_id' => $book->id,
            'title' => 'إضافة كتاب جديد',
            'description' => 'تمت إضافة كتاب جديد إلى المنصة.',
            'meta' => [
                'book_title' => $book->title,
                'price' => $book->price,
            ],
        ]);

        return redirect()->route('books.index')
                         ->with('success', 'تمت إضافة الكتاب بنجاح!');
    }

    public function show(Book $book)
    {
        // load() يحمّل العلاقة على سجل واحد موجود
        $book->load(['author', 'category', 'listedBy']);

        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors    = Author::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $before = $book->only(['title', 'price', 'available', 'published_year', 'pages']);

        $validated = $request->validated();
        $validated['available'] = $request->boolean('available');
        $validated['published'] = true;

        $book->update($validated);

        ActivityLog::create([
            'admin_user_id' => $request->user()->id,
            'action' => 'update_book',
            'entity_type' => Book::class,
            'entity_id' => $book->id,
            'title' => 'تعديل كتاب',
            'description' => 'تم تحديث بيانات كتاب داخل المنصة.',
            'meta' => [
                'before' => $before,
                'after' => $book->fresh()->only(['title', 'price', 'available', 'published_year', 'pages']),
            ],
        ]);

        return redirect()->route('books.index')
                         ->with('success', 'تم تعديل الكتاب بنجاح!');
    }

    public function destroy(Book $book)
    {
        $snapshot = $book->only(['title', 'price', 'available', 'published_year', 'pages']);

        $book->delete();

        ActivityLog::create([
            'admin_user_id' => request()->user()->id,
            'action' => 'delete_book',
            'entity_type' => Book::class,
            'entity_id' => $book->id,
            'title' => 'حذف كتاب',
            'description' => 'تم حذف كتاب من المنصة.',
            'meta' => [
                'book' => $snapshot,
            ],
        ]);

        return redirect()->route('books.index')
                         ->with('success', 'تم حذف الكتاب!');
    }
}