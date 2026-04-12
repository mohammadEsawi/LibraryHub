@extends('layouts.app')

@section('title', 'قائمة الكتب')

@section('content')
	<section class="books-header card">
		<div class="card-header">
			<div>
				<p class="admin-hero-kicker">Library</p>
				<h1 class="card-title">قائمة الكتب</h1>
				<p class="page-subtitle">استكشف واشتري الكتب من مكتبتنا الواسعة، أو اقرأ مجاناً.</p>
			</div>
			@auth
				@if (auth()->user()->role === 'admin')
					<a class="btn btn-primary" href="{{ route('books.create') }}">+ كتاب جديد</a>
				@endif
			@endauth
		</div>

		<form class="books-filter" method="GET" action="{{ route('books.index') }}">
			<div class="field">
				<label for="type">نوع الكتاب</label>
				<select id="type" name="type">
					<option value="all" @selected($type === 'all')>كل الكتب</option>
					<option value="premium" @selected($type === 'premium')>كتب بريميوم</option>
					<option value="free" @selected($type === 'free')>كتب مجانية</option>
				</select>
			</div>

			<div class="actions">
				<button class="btn btn-primary" type="submit">بحث</button>
			</div>
		</form>
	</section>

	<div class="books-grid">
		@forelse($books as $book)
			<article class="book-card">
				<div class="book-card-image">
					<div class="book-card-placeholder">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3.042.525A9.006 9.006 0 002.25 9m12-7.5h3.75m-3.75 0a9 9 0 013.042.525A9.006 9.006 0 0121.75 9M6 12a6 6 0 11-12 0 6 6 0 0112 0zm12 6a4 4 0 11-8 0 4 4 0 018 0z" />
						</svg>
					</div>
					@if ($book->price > 0)
						<span class="book-card-badge book-card-badge-premium">بريميوم</span>
					@else
						<span class="book-card-badge book-card-badge-free">مجاني</span>
					@endif
				</div>

				<div class="book-card-body">
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

					<div class="book-card-rating">
						<div class="stars">
							⭐⭐⭐⭐⭐
						</div>
						<span class="rating-text">(24 تقييم)</span>
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

							@auth
								@if (in_array(auth()->user()->role, ['customer', 'reader'], true))
									@if ($book->price > 0)
										<a class="btn btn-primary btn-sm" href="{{ route('checkout.show', $book) }}">شراء</a>
									@else
										<form action="{{ route('books.reading-list', $book) }}" method="POST">
											@csrf
											<button class="btn btn-primary btn-sm" type="submit">اقرأ</button>
										</form>
									@endif

									<form action="{{ route('books.reading-list', $book) }}" method="POST">
										@csrf
										<button class="btn btn-secondary btn-sm" type="submit">📚</button>
									</form>
								@endif

								@if (auth()->user()->role === 'admin')
									<a class="btn btn-secondary btn-sm" href="{{ route('books.edit', $book) }}">تعديل</a>
									<form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('حذف الكتاب؟')">
										@csrf
										@method('DELETE')
										<button class="btn btn-danger btn-sm" type="submit">حذف</button>
									</form>
								@endif
							@endauth
						</div>
					</div>
				</div>
			</article>
		@empty
			<div style="grid-column: 1 / -1; text-align: center; padding: 40px;">
				<p style="font-size: 1.1rem; color: var(--muted);">لا توجد كتب متاحة حالياً.</p>
			</div>
		@endforelse
	</div>

	<div class="pagination" style="margin-top: 40px;">
		{{ $books->links() }}
	</div>
@endsection
