@extends('layouts.app')

@section('title', 'إدارة طلبات المؤلفين')

@section('content')
    <section class="card">
        <div class="card-header">
            <div>
                <h1 class="card-title">طلبات المؤلفين</h1>
                <p class="page-subtitle">موافقة أو رفض طلبات بيع الكتب.</p>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>المؤلف</th>
                        <th>العنوان</th>
                        <th>التصنيف</th>
                        <th>السعر</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $submission)
                        <tr>
                            <td>{{ $submission->user?->name }}</td>
                            <td>{{ $submission->title }}</td>
                            <td>{{ $submission->category?->name }}</td>
                            <td>{{ number_format((float) $submission->proposed_price, 2) }}</td>
                            <td>{{ $submission->status }}</td>
                            <td>
                                @if ($submission->status === 'pending')
                                    <div class="actions">
                                        <form action="{{ route('admin.submissions.approve', $submission) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-primary" type="submit">موافقة</button>
                                        </form>

                                        <form action="{{ route('admin.submissions.reject', $submission) }}" method="POST">
                                            @csrf
                                            <input type="text" name="admin_note" placeholder="سبب الرفض" required>
                                            <button class="btn btn-danger" type="submit">رفض</button>
                                        </form>
                                    </div>
                                @else
                                    {{ $submission->admin_note ?? '-' }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">لا توجد طلبات حالياً.</td>
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
