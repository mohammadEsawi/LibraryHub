<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->string('range', 'day')->toString();
        [$startDate, $endDate, $rangeLabel] = $this->resolveRange($range);

        $logs = ActivityLog::with('adminUser')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total' => ActivityLog::whereBetween('created_at', [$startDate, $endDate])->count(),
            'approvals' => ActivityLog::whereBetween('created_at', [$startDate, $endDate])->where('action', 'approve_submission')->count(),
            'rejections' => ActivityLog::whereBetween('created_at', [$startDate, $endDate])->where('action', 'reject_submission')->count(),
            'creates' => ActivityLog::whereBetween('created_at', [$startDate, $endDate])->where('action', 'create_book')->count(),
            'updates' => ActivityLog::whereBetween('created_at', [$startDate, $endDate])->where('action', 'update_book')->count(),
            'deletes' => ActivityLog::whereBetween('created_at', [$startDate, $endDate])->where('action', 'delete_book')->count(),
        ];

        return view('admin.activity-log', compact('logs', 'stats', 'range', 'rangeLabel'));
    }

    private function resolveRange(string $range): array
    {
        if ($range === 'month') {
            return [
                now()->subMonths(5)->startOfMonth(),
                now()->endOfMonth(),
                'شهري',
            ];
        }

        return [
            now()->subDays(6)->startOfDay(),
            now()->endOfDay(),
            'يومي',
        ];
    }
}
