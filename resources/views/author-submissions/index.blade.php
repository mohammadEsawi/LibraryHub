@extends('layouts.app')

@section('title', 'طلبات بيع الكتب')

@section('content')
    @php($defaultBookImage = asset('images/book.jpg'))

    <section class="card">
        <div class="card-header">
            <div>
                <h1 class="card-title">طلبات بيع الكتب</h1>
                <p class="page-subtitle">متابعة حالة الطلبات الخاصة بك ورصيد أرباحك من مبيعات المتجر.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('books.create') }}">إضافة كتاب للبيع</a>
                <a class="btn btn-primary" href="{{ route('author-submissions.create') }}">طلب جديد</a>
            </div>
        </div>

        <div class="table-wrap">
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

        <div class="books-grid section-gap">
            @forelse($submissions as $submission)
                <article class="submission-card">
                    <h3 class="submission-card-title">{{ $submission->title }}</h3>
                    <p class="submission-card-meta"><strong>التصنيف:</strong> {{ $submission->category?->name ?? '-' }}</p>
                    <p class="submission-card-meta"><strong>السعر المقترح:</strong> ₪{{ number_format((float) $submission->proposed_price, 2) }}</p>
                    <p class="submission-card-meta"><strong>الحالة:</strong> {{ $submission->status }}</p>
                    <p class="submission-card-note"><strong>ملاحظة الإدارة:</strong> {{ $submission->admin_note ?? '-' }}</p>
                </article>
            @empty
                <div class="empty-state">
                    <p class="empty-state-text">لا توجد طلبات بعد.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination">
            {{ $submissions->links() }}
        </div>
    </section>

    <section class="card section-gap">
        <div class="card-header">
            <div>
                <h2 class="card-title">كتبي المعروضة</h2>
                <p class="page-subtitle">عرض الكتب التي قمت بإضافتها ككروت.</p>
            </div>
        </div>

        <div class="books-grid">
            @forelse($listedBooks as $book)
                <article class="book-card">
                    <div class="book-card-image">
                        <img
                            src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : $defaultBookImage }}"
                            alt="غلاف {{ $book->title }}"
                            class="book-card-cover"
                        >
                    </div>

                    <div class="book-card-body">
                        <div class="book-card-top">
                            @if ($book->price > 0)
                                <span class="book-card-badge book-card-badge-premium">بريميوم</span>
                            @else
                                <span class="book-card-badge book-card-badge-free">مجاني</span>
                            @endif
                        </div>

                        <h3 class="book-card-title">{{ $book->title }}</h3>
                        <p class="book-card-author">{{ $book->author?->name ?? 'غير معروف' }}</p>
                        <p class="book-card-category">{{ $book->category?->name ?? '-' }}</p>

                        <div class="book-card-meta">
                            <span class="meta-item">
                                <span class="meta-label">سنة</span>
                                <span class="meta-value">{{ $book->published_year }}</span>
                            </span>
                            <span class="meta-item">
                                <span class="meta-label">صفحات</span>
                                <span class="meta-value">{{ $book->pages }}</span>
                            </span>
                        </div>

                        <div class="book-card-footer">
                            <div>
                                @if ($book->price > 0)
                                    <p class="book-card-price">₪{{ number_format((float) $book->price, 2) }}</p>
                                @else
                                    <p class="book-card-price book-card-price-free">🎁 مجاني</p>
                                @endif
                            </div>

                            <div class="book-card-actions">
                                <a class="btn btn-secondary btn-sm" href="{{ route('books.show', $book) }}">عرض</a>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <p class="empty-state-text">لا توجد كتب معروضة حتى الآن.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
