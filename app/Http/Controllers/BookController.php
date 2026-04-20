<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $type = request()->string('type', 'all')->toString();
        $q = trim(request()->string('q')->toString());
        
        $query = Book::with(['author', 'category', 'listedBy'])
                     ->where('available', true)
                     ->latest();

        if ($q !== '') {
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('title', 'like', "%{$q}%")
                    ->orWhereHas('author', function ($authorQuery) use ($q) {
                        $authorQuery->where('name', 'like', "%{$q}%");
                    })
                    ->orWhereHas('category', function ($categoryQuery) use ($q) {
                        $categoryQuery->where('name', 'like', "%{$q}%");
                    });
            });
        }
        
        if ($type === 'premium') {
            $query->where('price', '>', 0);
        } elseif ($type === 'free') {
            $query->where('price', 0);
        }
        
        $books = $query->paginate(12)->withQueryString();

        return view('books.index', compact('books', 'type', 'q'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('books.create', compact('categories'));
    }

    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();
        $author = Author::firstOrCreate(['name' => trim($validated['author_name'])]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('book-covers', 'public');
        }

        $validated['author_id'] = $author->id;
        unset($validated['author_name']);
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
        $categories = Category::orderBy('name')->get();

        return view('books.edit', compact('book', 'categories'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $before = $book->only(['title', 'price', 'available', 'published_year', 'pages', 'cover_image']);

        $validated = $request->validated();
        $author = Author::firstOrCreate(['name' => trim($validated['author_name'])]);

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $validated['cover_image'] = $request->file('cover_image')->store('book-covers', 'public');
        }

        $validated['author_id'] = $author->id;
        unset($validated['author_name']);
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
                'after' => $book->fresh()->only(['title', 'price', 'available', 'published_year', 'pages', 'cover_image']),
            ],
        ]);

        return redirect()->route('books.index')
                         ->with('success', 'تم تعديل الكتاب بنجاح!');
    }

    public function destroy(Book $book)
    {
        $snapshot = $book->only(['title', 'price', 'available', 'published_year', 'pages', 'cover_image']);

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

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