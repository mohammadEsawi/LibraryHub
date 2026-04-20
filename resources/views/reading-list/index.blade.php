@extends('layouts.app')

@section('title', 'قائمة القراءة')

@section('content')
    @php($defaultBookImage = asset('images/book.jpg'))

    <section class="books-header card">
        <div class="card-header">
            <div>
                <p class="admin-hero-kicker">Reader</p>
                <h1 class="card-title">قائمة القراءة</h1>
                <p class="page-subtitle">الكتب التي قمت بإضافتها للقراءة.</p>
            </div>
            <a class="btn btn-secondary" href="{{ route('books.index') }}">العودة إلى الكتب</a>
        </div>
    </section>

    <div class="books-grid">
        @forelse($entries as $entry)
            @php($book = $entry->book)
            @if($book)
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
                                @if ($book->price > 0)
                                    <a class="btn btn-primary btn-sm" href="{{ route('checkout.show', $book) }}">شراء</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
            @endif
        @empty
            <div class="empty-state">
                <p class="empty-state-text">لا توجد كتب في قائمة القراءة حالياً.</p>
            </div>
        @endforelse
    </div>

    <div class="pagination pagination-spaced">
        {{ $entries->links() }}
    </div>
@endsection
