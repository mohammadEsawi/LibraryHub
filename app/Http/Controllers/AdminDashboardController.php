<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\AuthorSubmission;
use App\Models\Book;
use App\Models\Purchase;
use App\Models\ReadingList;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->string('range', 'day')->toString();
        [$startDate, $endDate, $rangeLabel, $step, $format] = $this->resolveRange($range);

        $purchasesQuery = Purchase::whereBetween('created_at', [$startDate, $endDate]);
        $submissionsQuery = AuthorSubmission::whereBetween('created_at', [$startDate, $endDate]);
        $activityLogsQuery = ActivityLog::whereBetween('created_at', [$startDate, $endDate]);

        $labels = [];
        $revenueSeries = [];
        $purchasesSeries = [];
        $submissionsSeries = [];

        foreach (CarbonPeriod::create($startDate->copy()->startOfDay(), $step, $endDate->copy()->endOfDay()) as $date) {
            $key = $date->format($format);
            $labels[] = $range === 'month' ? $date->format('M Y') : $date->format('d M');
            $revenueSeries[$key] = 0;
            $purchasesSeries[$key] = 0;
            $submissionsSeries[$key] = 0;
        }

        foreach ($purchasesQuery->get(['created_at', 'price_paid']) as $purchase) {
            $key = Carbon::parse($purchase->created_at)->format($format);

            if (array_key_exists($key, $revenueSeries)) {
                $revenueSeries[$key] += (float) $purchase->price_paid;
                $purchasesSeries[$key] += 1;
            }
        }

        foreach ($submissionsQuery->get(['created_at']) as $submission) {
            $key = Carbon::parse($submission->created_at)->format($format);

            if (array_key_exists($key, $submissionsSeries)) {
                $submissionsSeries[$key] += 1;
            }
        }

        $stats = [
            'users_total' => User::count(),
            'authors_total' => User::where('role', 'author')->count(),
            'books_total' => Book::count(),
            'available_books' => Book::where('available', true)->count(),
            'pending_submissions' => AuthorSubmission::where('status', 'pending')->count(),
            'approved_submissions' => AuthorSubmission::where('status', 'approved')->count(),
            'purchases_total' => $purchasesQuery->count(),
            'revenue_total' => (float) $purchasesQuery->sum('price_paid'),
            'reading_entries_total' => ReadingList::whereBetween('created_at', [$startDate, $endDate])->count(),
            'submissions_total' => $submissionsQuery->count(),
            'activity_logs_total' => $activityLogsQuery->count(),
        ];

        $latestUsers = User::latest()->take(6)->get();
        $latestPurchases = Purchase::with(['user', 'book'])->latest('purchased_at')->take(8)->get();
        $latestSubmissions = AuthorSubmission::with(['user', 'category'])->latest()->take(8)->get();
        $latestBooks = Book::with(['author', 'category'])->latest()->take(8)->get();
        $latestActivityLogs = ActivityLog::with('adminUser')->latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'stats',
            'range',
            'rangeLabel',
            'labels',
            'revenueSeries',
            'purchasesSeries',
            'submissionsSeries',
            'latestUsers',
            'latestPurchases',
            'latestSubmissions',
            'latestBooks',
            'latestActivityLogs'
        ));
    }

    private function resolveRange(string $range): array
    {
        if ($range === 'month') {
            return [
                now()->subMonths(5)->startOfMonth(),
                now()->endOfMonth(),
                'شهري',
                '1 month',
                'Y-m',
            ];
        }

        return [
            now()->subDays(6)->startOfDay(),
            now()->endOfDay(),
            'يومي',
            '1 day',
            'Y-m-d',
        ];
    }
}
