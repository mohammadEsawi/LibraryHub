@extends('layouts.app')

@section('title', 'تفاصيل الكتاب')

@section('content')
	<section class="card stack">
		<div class="card-header">
			<div>
				<h1 class="card-title">{{ $book->title }}</h1>
				<p class="page-subtitle">تفاصيل الكتاب في المكتبة.</p>
			</div>
			<span class="badge {{ $book->available ? 'badge-available' : 'badge-unavailable' }}">
				{{ $book->available ? 'متاح' : 'غير متاح' }}
			</span>
		</div>

		<div class="meta-grid">
			<article class="meta-item">
				<p class="meta-label">المؤلف</p>
				<p class="meta-value">{{ $book->author?->name ?? '-' }}</p>
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
			<article class="meta-item">
				<p class="meta-label">السعر</p>
				<p class="meta-value">{{ number_format((float) $book->price, 2) }}</p>
			</article>
			<article class="meta-item">
				<p class="meta-label">مضاف بواسطة</p>
				<p class="meta-value">{{ $book->listedBy?->name ?? 'إدارة المنصة' }}</p>
			</article>
		</div>

		<div class="actions">
			<a class="btn btn-secondary" href="{{ route('books.index') }}">رجوع</a>

			@auth
				@if (in_array(auth()->user()->role, ['customer', 'reader'], true))
					<form action="{{ route('books.purchase', $book) }}" method="POST">
						@csrf
						<button class="btn btn-primary" type="submit">شراء</button>
					</form>

					<form action="{{ route('books.reading-list', $book) }}" method="POST">
						@csrf
						<button class="btn btn-secondary" type="submit">إضافة للقراءة</button>
					</form>
				@endif

				@if (auth()->user()->role === 'admin')
					<a class="btn btn-primary" href="{{ route('books.edit', $book) }}">تعديل</a>
				@endif
			@endauth
		</div>
	</section>
@endsection
