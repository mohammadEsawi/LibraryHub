@extends('layouts.app')

@section('title', 'طلبات بيع الكتب')

@section('content')
    <section class="card">
        <div class="card-header">
            <div>
                <h1 class="card-title">طلبات بيع الكتب</h1>
                <p class="page-subtitle">متابعة حالة الطلبات الخاصة بك.</p>
            </div>
            <a class="btn btn-primary" href="{{ route('author-submissions.create') }}">طلب جديد</a>
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
