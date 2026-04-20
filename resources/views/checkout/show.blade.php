@extends('layouts.app')

@section('title', 'الدفع - ' . $book->title)

@section('content')
	<section class="card checkout-card">
		<div class="checkout-head">
			<h1 class="checkout-title">✓ تأكيد الشراء</h1>
			<p class="page-subtitle">يرجى مراجعة تفاصيل الكتاب قبل الدفع</p>
		</div>

		<!-- تفاصيل الكتاب -->
		<div class="checkout-book">
			<div class="checkout-book-content">
				<div class="checkout-book-cover">
					<p>📸</p>
				</div>
				<div class="checkout-book-meta">
					<p class="checkout-book-label">الكتاب</p>
					<h3 class="checkout-book-title">{{ $book->title }}</h3>
					<p class="checkout-book-line checkout-book-line-accent">
						<strong>المؤلف:</strong> {{ $book->author?->name ?? 'غير معروف' }}
					</p>
					<p class="checkout-book-line">
						<strong>النوع:</strong> {{ $book->category?->name ?? '-' }}
					</p>
				</div>
			</div>
		</div>

		<!-- ملخص الدفع -->
		<div class="checkout-summary">
			<div class="checkout-row">
				<span class="checkout-label">سعر الكتاب</span>
				<span class="checkout-value">₪{{ number_format((float) $book->price, 2) }}</span>
			</div>
			<div class="checkout-row">
				<span class="checkout-label">رسوم المنصة</span>
				<span class="checkout-value">₪0.00</span>
			</div>
			<div class="checkout-row">
				<span class="checkout-total-label">المبلغ الإجمالي</span>
				<span class="checkout-total-value">₪{{ number_format((float) $book->price, 2) }}</span>
			</div>
		</div>

		<!-- زر الدفع -->
		<form action="{{ route('checkout.process', $book) }}" method="POST" class="section-gap">
			@csrf
			<button type="submit" class="btn btn-primary btn-lg btn-block">
				💳 أتمم عملية الدفع
			</button>
		</form>

		<!-- زر العودة -->
		<a href="{{ route('books.show', $book) }}" class="btn btn-secondary btn-block">
			← العودة للكتاب
		</a>

		<!-- ملاحظة أمنية -->
		<div class="checkout-note">
			<p>
				🔒 عملية الدفع آمنة وموثوقة. سيتم حفظ الكتاب في مكتبتك بعد إتمام الشراء.
			</p>
		</div>
	</section>
@endsection
