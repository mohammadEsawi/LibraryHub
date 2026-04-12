@extends('layouts.app')

@section('title', 'الدفع - ' . $book->title)

@section('content')
	<section class="card" style="max-width: 600px; margin: 40px auto;">
		<div style="margin-bottom: 28px;">
			<h1 style="margin: 0 0 8px 0; font-size: 1.8rem;">✓ تأكيد الشراء</h1>
			<p style="margin: 0; color: var(--muted);">يرجى مراجعة تفاصيل الكتاب قبل الدفع</p>
		</div>

		<!-- تفاصيل الكتاب -->
		<div style="padding: 20px; background: #f9f0e1; border-radius: 12px; margin-bottom: 24px; border: 1px solid #e8d0b6;">
			<div style="display: flex; gap: 20px; margin-bottom: 20px;">
				<div style="width: 80px; min-width: 80px; height: 120px; background: linear-gradient(135deg, #9b3d2a 0%, #d8a15b 50%, #f9f0e1 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 1px solid #d8a15b;">
					<p style="margin: 0; text-align: center; color: #5d3f2a;">📸</p>
				</div>
				<div style="flex: 1;">
					<p style="margin: 0 0 4px 0; font-size: 0.85rem; color: var(--muted); text-transform: uppercase; font-weight: 600;">الكتاب</p>
					<h3 style="margin: 0 0 8px 0; font-size: 1.2rem; color: #4e3f2e;">{{ $book->title }}</h3>
					<p style="margin: 0 0 6px 0; font-size: 0.95rem; color: #9b3d2a;">
						<strong>المؤلف:</strong> {{ $book->author?->name ?? 'غير معروف' }}
					</p>
					<p style="margin: 0; font-size: 0.95rem; color: #4e3f2e;">
						<strong>النوع:</strong> {{ $book->category?->name ?? '-' }}
					</p>
				</div>
			</div>
		</div>

		<!-- ملخص الدفع -->
		<div style="padding: 20px; background: #fff; border: 2px solid #d8a15b; border-radius: 12px; margin-bottom: 24px;">
			<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #e8d0b6;">
				<span style="color: var(--muted); font-weight: 600;">سعر الكتاب</span>
				<span style="font-size: 1.05rem; font-weight: 700; color: #4e3f2e;">₪{{ number_format((float) $book->price, 2) }}</span>
			</div>
			<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #e8d0b6;">
				<span style="color: var(--muted); font-weight: 600;">رسوم المنصة</span>
				<span style="font-size: 1rem; font-weight: 700; color: #4e3f2e;">₪0.00</span>
			</div>
			<div style="display: flex; justify-content: space-between; align-items: center;">
				<span style="font-size: 1.1rem; font-weight: 700; color: #9b3d2a;">المبلغ الإجمالي</span>
				<span style="font-size: 1.4rem; font-weight: 900; color: #d8a15b;">₪{{ number_format((float) $book->price, 2) }}</span>
			</div>
		</div>

		<!-- زر الدفع -->
		<form action="{{ route('checkout.process', $book) }}" method="POST" style="margin-bottom: 16px;">
			@csrf
			<button type="submit" class="btn btn-primary btn-lg" style="width: 100%; padding: 16px;">
				💳 أتمم عملية الدفع
			</button>
		</form>

		<!-- زر العودة -->
		<a href="{{ route('books.show', $book) }}" class="btn btn-secondary" style="width: 100%; text-align: center; padding: 12px; display: block;">
			← العودة للكتاب
		</a>

		<!-- ملاحظة أمنية -->
		<div style="margin-top: 24px; padding: 12px; background: #e8f5e9; border-radius: 8px; border-left: 4px solid #4caf50;">
			<p style="margin: 0; font-size: 0.9rem; color: #2e7d32;">
				🔒 عملية الدفع آمنة وموثوقة. سيتم حفظ الكتاب في مكتبتك بعد إتمام الشراء.
			</p>
		</div>
	</section>
@endsection
