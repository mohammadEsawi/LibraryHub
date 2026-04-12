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
		</div>

		<div class="actions">
			<a class="btn btn-secondary" href="{{ route('books.index') }}">رجوع</a>
			<a class="btn btn-primary" href="{{ route('books.edit', $book) }}">تعديل</a>
		</div>
	</section>
@endsection
