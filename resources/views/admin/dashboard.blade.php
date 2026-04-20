@extends('layouts.app')

@section('title', 'لوحة تحكم الأدمن')

@section('content')
    <section class="admin-hero card">
        <div class="admin-hero-copy">
            <p class="admin-hero-kicker">Admin Overview</p>
            <h1 class="card-title">لوحة تحكم الأدمن</h1>
            <p class="page-subtitle">كل ما تحتاجه لإدارة الكتب، الطلبات، المشتريات، والعمليات من مكان واحد.</p>
        </div>

        <div class="admin-hero-actions">
            <a class="btn btn-primary" href="{{ route('books.create') }}">إضافة كتاب</a>
            <a class="btn btn-secondary" href="{{ route('admin.submissions.index') }}">إدارة الطلبات</a>
            <a class="btn btn-secondary" href="{{ route('admin.activity-log') }}">Activity Log</a>
        </div>

        <form class="dashboard-filter" method="GET" action="{{ route('admin.dashboard') }}">
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
    </section>

    <section class="dashboard-summary card">
        <div class="summary-hero">
            <div>
                <p class="panel-kicker">Period Summary</p>
                <h2 class="section-title">ملخص الفترة</h2>
                <p class="page-subtitle">مرحباً {{ auth()->user()->name }}، هذه نظرة سريعة على أداء المنصة خلال {{ $rangeLabel }}.</p>
            </div>

            <div class="summary-pill-group">
                <span class="summary-pill">الفترة: {{ $rangeLabel }}</span>
                <span class="summary-pill">الكتب: {{ $stats['books_total'] }}</span>
                <span class="summary-pill">الإيراد: {{ number_format($stats['revenue_total'], 2) }}</span>
                <span class="summary-pill">متاح: {{ $inventory['available'] }}</span>
            </div>
        </div>

        <div class="dashboard-summary-table-wrap">
            <table class="summary-table">
                <thead>
                    <tr>
                        <th>المؤشر</th>
                        <th>القيمة</th>
                        <th>الملاحظة</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>إجمالي الإيراد</td>
                        <td class="summary-table-value summary-table-value-strong">{{ number_format($stats['revenue_total'], 2) }}</td>
                        <td>إجمالي المبيعات خلال الفترة المختارة</td>
                    </tr>
                    <tr>
                        <td>المشتريات</td>
                        <td class="summary-table-value">{{ $stats['purchases_total'] }}</td>
                        <td>عدد الطلبات المكتملة خلال الفترة</td>
                    </tr>
                    <tr>
                        <td>طلبات المؤلفين</td>
                        <td class="summary-table-value">{{ $stats['submissions_total'] }}</td>
                        <td>الطلبات الجديدة قيد المتابعة</td>
                    </tr>
                    <tr>
                        <td>إجمالي المستخدمين</td>
                        <td class="summary-table-value">{{ $stats['users_total'] }}</td>
                        <td>كل الحسابات المسجلة في النظام</td>
                    </tr>
                    <tr>
                        <td>إجمالي المؤلفين</td>
                        <td class="summary-table-value">{{ $stats['authors_total'] }}</td>
                        <td>الحسابات التي تملك دور مؤلف</td>
                    </tr>
                    <tr>
                        <td>إجمالي الكتب</td>
                        <td class="summary-table-value">{{ $stats['books_total'] }}</td>
                        <td>كل الكتب الموجودة في المنصة</td>
                    </tr>
                    <tr>
                        <td>الكتب المتاحة</td>
                        <td class="summary-table-value">{{ $stats['available_books'] }}</td>
                        <td>الكتب الجاهزة للبيع أو العرض</td>
                    </tr>
                    <tr>
                        <td>طلبات قيد المراجعة</td>
                        <td class="summary-table-value">{{ $stats['pending_submissions'] }}</td>
                        <td>الطلبات التي تنتظر قرار الأدمن</td>
                    </tr>
                    <tr>
                        <td>طلبات تمت الموافقة</td>
                        <td class="summary-table-value">{{ $stats['approved_submissions'] }}</td>
                        <td>الطلبات المعتمدة والمقبولة</td>
                    </tr>
                    <tr>
                        <td>عمليات القراءة</td>
                        <td class="summary-table-value">{{ $stats['reading_entries_total'] }}</td>
                        <td>الإضافات الموجودة في قائمة القراءة</td>
                    </tr>
                    <tr>
                        <td>سجل العمليات</td>
                        <td class="summary-table-value">{{ $stats['activity_logs_total'] }}</td>
                        <td>كل الإجراءات الإدارية المسجلة</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="card stack dashboard-panel">
        <div class="card-header">
            <div>
                <p class="panel-kicker">Inventory</p>
                <h2 class="card-title">Book Inventory Count</h2>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>المؤشر</th>
                        <th>القيمة</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>إجمالي الكتب</td>
                        <td>{{ $inventory['total'] }}</td>
                    </tr>
                    <tr>
                        <td>كتب متاحة</td>
                        <td>{{ $inventory['available'] }}</td>
                    </tr>
                    <tr>
                        <td>كتب غير متاحة</td>
                        <td>{{ $inventory['unavailable'] }}</td>
                    </tr>
                    <tr>
                        <td>كتب مدفوعة</td>
                        <td>{{ $inventory['premium'] }}</td>
                    </tr>
                    <tr>
                        <td>كتب مجانية</td>
                        <td>{{ $inventory['free'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="dashboard-charts-grid">
        <article class="card stack dashboard-panel">
            <div class="card-header">
                <div>
                    <p class="panel-kicker">Sales</p>
                    <h2 class="card-title">Top-Selling Books</h2>
                </div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>الكتاب</th>
                            <th>عدد المبيعات</th>
                            <th>الإيراد</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($topSellingBooks as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->sales_count }}</td>
                                <td>{{ number_format((float) $item->revenue_total, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3">لا توجد مبيعات خلال الفترة المختارة.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>

        <article class="card stack dashboard-panel">
            <div class="card-header">
                <div>
                    <p class="panel-kicker">Reports</p>
                    <h2 class="card-title">Revenue by Book Report</h2>
                </div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>الكتاب</th>
                            <th>عدد المبيعات</th>
                            <th>الإيراد الكلي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($revenueByBook as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->sales_count }}</td>
                                <td>{{ number_format((float) $item->revenue_total, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3">لا توجد بيانات إيراد للكتب في هذه الفترة.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>
    </section>

    <section class="dashboard-charts-grid">
        <article class="card chart-card dashboard-panel">
            <div class="card-header">
                <div>
                    <p class="panel-kicker">Revenue</p>
                    <h2 class="card-title">الإيراد حسب الفترة</h2>
                    <p class="page-subtitle">مخطط الإيراد الخاص بالفترة المختارة.</p>
                </div>
            </div>
            <canvas id="revenueChart" height="120"></canvas>
        </article>

        <article class="card chart-card dashboard-panel">
            <div class="card-header">
                <div>
                    <p class="panel-kicker">Orders</p>
                    <h2 class="card-title">الطلبات حسب الفترة</h2>
                    <p class="page-subtitle">عدد المشتريات وطلبات المؤلفين.</p>
                </div>
            </div>
            <canvas id="ordersChart" height="120"></canvas>
        </article>
    </section>

    <section class="card stack dashboard-panel">
        <div class="card-header">
            <div>
                <p class="panel-kicker">Operations</p>
                <h2 class="card-title">آخر المشتريات</h2>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>المستخدم</th>
                        <th>الكتاب</th>
                        <th>السعر</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestPurchases as $purchase)
                        <tr>
                            <td>{{ $purchase->user?->name ?? '-' }}</td>
                            <td>{{ $purchase->book?->title ?? '-' }}</td>
                            <td>{{ number_format((float) $purchase->price_paid, 2) }}</td>
                            <td>{{ optional($purchase->purchased_at)->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">لا توجد مشتريات بعد.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="card stack dashboard-panel">
        <div class="card-header">
            <div>
                <p class="panel-kicker">Operations</p>
                <h2 class="card-title">آخر طلبات المؤلفين</h2>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>المؤلف</th>
                        <th>العنوان</th>
                        <th>التصنيف</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestSubmissions as $submission)
                        <tr>
                            <td>{{ $submission->user?->name ?? '-' }}</td>
                            <td>{{ $submission->title }}</td>
                            <td>{{ $submission->category?->name ?? '-' }}</td>
                            <td>{{ $submission->status }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">لا توجد طلبات حالياً.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="card stack dashboard-panel">
        <div class="card-header">
            <div>
                <p class="panel-kicker">Library</p>
                <h2 class="card-title">آخر الكتب المضافة</h2>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>العنوان</th>
                        <th>المؤلف</th>
                        <th>التصنيف</th>
                        <th>السعر</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestBooks as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author?->name ?? '-' }}</td>
                            <td>{{ $book->category?->name ?? '-' }}</td>
                            <td>{{ number_format((float) $book->price, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">لا توجد كتب بعد.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="card stack dashboard-panel">
        <div class="card-header">
            <div>
                <p class="panel-kicker">Tracking</p>
                <h2 class="card-title">آخر Activity Log</h2>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>الأدمن</th>
                        <th>الإجراء</th>
                        <th>العنوان</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestActivityLogs as $log)
                        <tr>
                            <td>{{ $log->adminUser?->name ?? '-' }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->title }}</td>
                            <td>{{ optional($log->created_at)->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">لا توجد سجلات بعد.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const labels = @json($labels);
            const revenueData = @json(array_values($revenueSeries));
            const purchasesData = @json(array_values($purchasesSeries));
            const submissionsData = @json(array_values($submissionsSeries));

            const revenueCanvas = document.getElementById('revenueChart');
            const ordersCanvas = document.getElementById('ordersChart');

            if (revenueCanvas) {
                new Chart(revenueCanvas, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                            label: 'الإيراد',
                            data: revenueData,
                            borderColor: '#9b3d2a',
                            backgroundColor: 'rgba(155, 61, 42, 0.12)',
                            tension: 0.35,
                            fill: true,
                        }],
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: true } },
                        scales: { y: { beginAtZero: true } },
                    },
                });
            }

            if (ordersCanvas) {
                new Chart(ordersCanvas, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [
                            {
                                label: 'المشتريات',
                                data: purchasesData,
                                backgroundColor: '#9b3d2a',
                            },
                            {
                                label: 'طلبات المؤلفين',
                                data: submissionsData,
                                backgroundColor: '#d8a15b',
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: true } },
                        scales: { y: { beginAtZero: true, precision: 0 } },
                    },
                });
            }
        </script>
    @endpush
@endsection
