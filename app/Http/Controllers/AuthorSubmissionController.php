<?php

namespace App\Http\Controllers;

use App\Models\AuthorSubmission;
use App\Models\Category;
use Illuminate\Http\Request;

class AuthorSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $submissions = AuthorSubmission::with('category')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('author-submissions.index', compact('submissions'));
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
