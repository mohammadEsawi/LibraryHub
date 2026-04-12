@extends('layouts.app')

@section('title', 'Activity Log')

@section('content')
    <section class="card stack dashboard-panel">
        <div class="card-header">
            <div>
                <p class="panel-kicker">Tracking</p>
                <h1 class="card-title">Activity Log</h1>
                <p class="page-subtitle">سجل تفصيلي لكل إجراء إداري داخل النظام.</p>
            </div>
            <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">رجوع للوحة الأدمن</a>
        </div>

        <form class="dashboard-filter" method="GET" action="{{ route('admin.activity-log') }}">
            <div class="field">
                <label for="range">الفترة</label>
                <select id="range" name="range">
                    <option value="day" @selected($range === 'day')>يومي</option>
                    <option value="month" @selected($range === 'month')>شهري</option>
                </select>
            </div>

            <div class="actions">
                <button class="btn btn-primary" type="submit">تحديث</button>
            </div>
        </form>

        <div class="dashboard-summary-table-wrap">
            <table class="summary-table summary-table-compact">
                <thead>
                    <tr>
                        <th>المؤشر</th>
                        <th>القيمة</th>
                        <th>الملاحظة</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>إجمالي السجلات</td>
                        <td class="summary-table-value summary-table-value-strong">{{ $stats['total'] }}</td>
                        <td>إجمالي عمليات Activity Log ضمن الفترة</td>
                    </tr>
                    <tr>
                        <td>موافقات</td>
                        <td class="summary-table-value">{{ $stats['approvals'] }}</td>
                        <td>الطلبات التي تم اعتمادها</td>
                    </tr>
                    <tr>
                        <td>رفض</td>
                        <td class="summary-table-value">{{ $stats['rejections'] }}</td>
                        <td>الطلبات التي تم رفضها</td>
                    </tr>
                    <tr>
                        <td>إضافات كتب</td>
                        <td class="summary-table-value">{{ $stats['creates'] }}</td>
                        <td>الكتب التي أُضيفت حديثًا</td>
                    </tr>
                    <tr>
                        <td>تعديلات كتب</td>
                        <td class="summary-table-value">{{ $stats['updates'] }}</td>
                        <td>الكتب التي تم تعديلها</td>
                    </tr>
                    <tr>
                        <td>حذف كتب</td>
                        <td class="summary-table-value">{{ $stats['deletes'] }}</td>
                        <td>الكتب التي تم حذفها</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="card stack dashboard-panel">
        <div class="card-header">
            <div>
                <p class="panel-kicker">Details</p>
                <h2 class="card-title">تفاصيل السجل</h2>
                <p class="page-subtitle">الفترة الحالية: {{ $rangeLabel }}</p>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>الأدمن</th>
                        <th>الإجراء</th>
                        <th>العنوان</th>
                        <th>الوصف</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log->adminUser?->name ?? '-' }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->title }}</td>
                            <td>{{ $log->description ?? '-' }}</td>
                            <td>{{ optional($log->created_at)->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5">لا توجد سجلات ضمن هذه الفترة.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $logs->links() }}
        </div>
    </section>
@endsection
