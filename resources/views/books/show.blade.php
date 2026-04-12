@extends('layouts.app')

@section('title', 'تفاصيل الكتاب')

@section('content')
	<section class="book-detail card">
		<div class="book-detail-header">
			<div class="book-detail-image" style="background: linear-gradient(135deg, #e8d0b6 0%, #f9f0e1 100%); display: flex; align-items: center; justify-content: center; flex-direction: column; text-align: center; padding: 20px;">
				<p style="font-size: 1.2rem; color: #9b3d2a; font-weight: 600; margin: 0;">📸</p>
				<p style="font-size: 1rem; color: #5d3f2a; font-weight: 600; margin: 10px 0 0 0;">سيتم توفر الصورة قريباً</p>
			</div>

			<div class="book-detail-info">
				<div class="book-detail-badges">
					<span class="badge {{ $book->available ? 'badge-available' : 'badge-unavailable' }}">
						{{ $book->available ? '✓ متاح' : '✗ غير متاح' }}
					</span>
					@if ($book->price > 0)
						<span class="badge badge-premium">بريميوم</span>
					@else
						<span class="badge badge-free">مجاني</span>
					@endif
				</div>

				<h1 class="book-detail-title">{{ $book->title }}</h1>

				<div class="book-detail-rating">
					<div class="stars">⭐⭐⭐⭐⭐</div>
					<span class="rating-meta">(24 تقييم)</span>
				</div>

				<div class="book-detail-meta">
					<article class="meta-item">
						<p class="meta-label">المؤلف</p>
						<p class="meta-value">{{ $book->author?->name ?? 'غير معروف' }}</p>
					</article>
					<article class="meta-item">
						<p class="meta-label">التصنيف</p>
						<p class="meta-value">{{ $book->category?->name ?? '-' }}</p>
					</article>
					<article class="meta-item">
						<p class="meta-label">سنة النشر</p>
						<p class="meta-value">{{ $book->published_year }}</p>
					</article>
					<article class="meta-item">
						<p class="meta-label">عدد الصفحات</p>
						<p class="meta-value">{{ $book->pages }}</p>
					</article>
				</div>

				<div class="book-detail-price-section">
					@if ($book->price > 0)
					<p class="book-detail-price">₪{{ number_format((float) $book->price, 2) }}</p>
				@else
					<p class="book-detail-price-free">🎉 مجاني</p>
				@endif
			</div>

				<div class="book-detail-actions">
					<a class="btn btn-secondary" href="{{ route('books.index') }}">← رجوع إلى المكتبة</a>

					@auth
						@if (in_array(auth()->user()->role, ['customer', 'reader'], true))
							@if ($book->price > 0)
								<a href="{{ route('checkout.show', $book) }}" class="btn btn-primary btn-lg">🛒 شراء الآن</a>
							@else
								<form action="{{ route('books.reading-list', $book) }}" method="POST">
									@csrf
									<button class="btn btn-primary btn-lg" type="submit">📖 ابدأ القراءة</button>
								</form>
							@endif

							<form action="{{ route('books.reading-list', $book) }}" method="POST">
								@csrf
								<button class="btn btn-secondary" type="submit">📚 إضافة للقراءة</button>
							</form>
						@endif

						@if (auth()->user()->role === 'admin')
							<a class="btn btn-primary" href="{{ route('books.edit', $book) }}">تعديل الكتاب</a>
							<form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف الكتاب؟')">
								@csrf
								@method('DELETE')
								<button class="btn btn-danger" type="submit">حذف الكتاب</button>
							</form>
						@endif
					@endauth
				</div>
			</div>
		</div>

		<div class="book-detail-description">
			<h2>عن الكتاب</h2>
			<p>هذا الكتاب يقدم محتوى غني وشامل يساعدك على فهم المواضيع الأساسية. مكتوب بلغة سهلة وواضحة مع أمثلة عملية وشروحات تفصيلية.</p>
		</div>

		<div class="book-detail-extra">
			<article class="extra-item">
				<p class="meta-label">المنصة المضيفة</p>
				<p class="meta-value">{{ $book->listedBy?->name ?? 'إدارة المنصة' }}</p>
			</article>
			<article class="extra-item">
				<p class="meta-label">تاريخ الإضافة</p>
				<p class="meta-value">{{ $book->created_at->format('Y-m-d') }}</p>
			</article>
		</div>
	</section>

	@auth
		@if (in_array(auth()->user()->role, ['customer', 'reader'], true))
			<section class="card" style="margin-top: 28px;">
				<h2 style="margin-top: 0;">كتب مشابهة</h2>
				<div class="books-grid">
					<!-- هنا يمكن إضافة كتب مشابهة -->
					<p style="grid-column: 1 / -1; color: var(--muted);">كتب مشابهة قريباً...</p>
				</div>
			</section>
		@endif
	@endauth
@endsection
