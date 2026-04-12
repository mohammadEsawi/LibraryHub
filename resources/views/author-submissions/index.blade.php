@extends('layouts.app')

@section('title', 'طلبات بيع الكتب')

@section('content')
    <section class="card">
        <div class="card-header">
            <div>
                <h1 class="card-title">طلبات بيع الكتب</h1>
                <p class="page-subtitle">متابعة حالة الطلبات الخاصة بك ورصيد أرباحك من مبيعات المتجر.</p>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a class="btn btn-secondary" href="{{ route('books.create') }}">إضافة كتاب للبيع</a>
                <a class="btn btn-primary" href="{{ route('author-submissions.create') }}">طلب جديد</a>
            </div>
        </div>

        <div class="table-wrap" style="margin-bottom: 18px;">
            <table>
                <thead>
                    <tr>
                        <th>رصيد الحساب</th>
                        <th>إجمالي المبيعات</th>
                        <th>كتب تم بيعها</th>
                        <th>الكتب المعروضة للبيع</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>₪{{ number_format($totalEarnings, 2) }}</strong></td>
                        <td>{{ $totalSales }}</td>
                        <td>{{ $soldBooksCount }}</td>
                        <td>{{ $listedBooksCount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>العنوان</th>
                        <th>التصنيف</th>
                        <th>السعر المقترح</th>
                        <th>الحالة</th>
                        <th>ملاحظة الإدارة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $submission)
                        <tr>
                            <td>{{ $submission->title }}</td>
                            <td>{{ $submission->category?->name }}</td>
                            <td>{{ number_format((float) $submission->proposed_price, 2) }}</td>
                            <td>{{ $submission->status }}</td>
                            <td>{{ $submission->admin_note ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">لا توجد طلبات بعد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $submissions->links() }}
        </div>
    </section>
@endsection
