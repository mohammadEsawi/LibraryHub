@extends('layouts.app')

@section('title', 'قائمة الكتب')

@section('content')
	<section class="card">
		<div class="card-header">
			<div>
				<h1 class="card-title">قائمة الكتب</h1>
				<p class="page-subtitle">إدارة سريعة لمحتوى المكتبة.</p>
			</div>
			<a class="btn btn-primary" href="{{ route('books.create') }}">+ كتاب جديد</a>
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
							<td>
								<span class="badge {{ $book->available ? 'badge-available' : 'badge-unavailable' }}">
									{{ $book->available ? 'متاح' : 'غير متاح' }}
								</span>
							</td>
							<td>
								<div class="actions">
									<a class="btn btn-secondary" href="{{ route('books.show', $book) }}">عرض</a>
									<a class="btn btn-secondary" href="{{ route('books.edit', $book) }}">تعديل</a>
									<form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('حذف الكتاب؟')">
										@csrf
										@method('DELETE')
										<button class="btn btn-danger" type="submit">حذف</button>
									</form>
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="7">لا توجد كتب حالياً.</td>
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
