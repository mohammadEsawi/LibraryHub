<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Author;
use App\Models\AuthorSubmission;
use App\Models\Book;
use Illuminate\Http\Request;

class AdminSubmissionController extends Controller
{
    public function index()
    {
        $submissions = AuthorSubmission::with(['user', 'category'])
            ->latest()
            ->paginate(15);

        return view('admin.submissions.index', compact('submissions'));
    }

    public function approve(Request $request, AuthorSubmission $submission)
    {
        if ($submission->status !== 'pending') {
            return back()->with('error', 'هذا الطلب تمت معالجته مسبقاً.');
        }

        $author = Author::firstOrCreate(
            ['name' => $submission->user->name],
            ['bio' => 'تم إنشاؤه تلقائياً من طلب المؤلف.']
        );

        $book = Book::create([
            'author_id' => $author->id,
            'category_id' => $submission->category_id,
            'title' => $submission->title,
            'published_year' => $submission->published_year ?? date('Y'),
            'pages' => $submission->pages,
            'published' => true,
            'available' => true,
            'price' => $submission->proposed_price,
            'listed_by_user_id' => $submission->user_id,
        ]);

        $submission->update([
            'status' => 'approved',
            'approved_book_id' => $book->id,
            'admin_note' => 'تمت الموافقة وإضافة الكتاب إلى المنصة.',
        ]);

        ActivityLog::create([
            'admin_user_id' => $request->user()->id,
            'action' => 'approve_submission',
            'entity_type' => AuthorSubmission::class,
            'entity_id' => $submission->id,
            'title' => 'موافقة على طلب مؤلف',
            'description' => 'تمت الموافقة على طلب المؤلف وإضافة الكتاب إلى المنصة.',
            'meta' => [
                'submission_title' => $submission->title,
                'book_id' => $book->id,
                'author_name' => $author->name,
            ],
        ]);

        return back()->with('success', 'تمت الموافقة على الطلب وإضافة الكتاب.');
    }

    public function reject(Request $request, AuthorSubmission $submission)
    {
        if ($submission->status !== 'pending') {
            return back()->with('error', 'هذا الطلب تمت معالجته مسبقاً.');
        }

        $validated = $request->validate([
            'admin_note' => 'required|string|max:500',
        ]);

        $submission->update([
            'status' => 'rejected',
            'admin_note' => $validated['admin_note'],
        ]);

        ActivityLog::create([
            'admin_user_id' => $request->user()->id,
            'action' => 'reject_submission',
            'entity_type' => AuthorSubmission::class,
            'entity_id' => $submission->id,
            'title' => 'رفض طلب مؤلف',
            'description' => 'تم رفض طلب المؤلف مع حفظ الملاحظة.',
            'meta' => [
                'submission_title' => $submission->title,
                'admin_note' => $validated['admin_note'],
            ],
        ]);

        return back()->with('success', 'تم رفض الطلب مع حفظ الملاحظة.');
    }
}
