@extends('layouts.app')

@section('title', 'قائمة الكتب')

@section('content')
	<section class="card">
		<div class="card-header">
			<div>
				<h1 class="card-title">قائمة الكتب</h1>
				<p class="page-subtitle">إدارة سريعة لمحتوى المكتبة.</p>
			</div>
			@auth
				@if (auth()->user()->role === 'admin')
					<a class="btn btn-primary" href="{{ route('books.create') }}">+ كتاب جديد</a>
				@endif
			@endauth
		</div>

		<div class="table-wrap">
			<table>
				<thead>
					<tr>
						<th>العنوان</th>
						<th>المؤلف</th>
						<th>التصنيف</th>
						<th>السنة</th>
						<th>الصفحات</th>
						<th>السعر</th>
						<th>الحالة</th>
						<th>الإجراءات</th>
					</tr>
				</thead>
				<tbody>
					@forelse($books as $book)
						<tr>
							<td>{{ $book->title }}</td>
							<td>{{ $book->author?->name ?? '-' }}</td>
							<td>{{ $book->category?->name ?? '-' }}</td>
							<td>{{ $book->published_year }}</td>
							<td>{{ $book->pages }}</td>
							<td>{{ number_format((float) $book->price, 2) }}</td>
							<td>
								<span class="badge {{ $book->available ? 'badge-available' : 'badge-unavailable' }}">
									{{ $book->available ? 'متاح' : 'غير متاح' }}
								</span>
							</td>
							<td>
								<div class="actions">
									<a class="btn btn-secondary" href="{{ route('books.show', $book) }}">عرض</a>

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
											<a class="btn btn-secondary" href="{{ route('books.edit', $book) }}">تعديل</a>
											<form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('حذف الكتاب؟')">
												@csrf
												@method('DELETE')
												<button class="btn btn-danger" type="submit">حذف</button>
											</form>
										@endif
									@endauth
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="8">لا توجد كتب حالياً.</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		<div class="pagination">
			{{ $books->links() }}
		</div>
	</section>
@endsection
