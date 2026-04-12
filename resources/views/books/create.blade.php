@extends('layouts.app')

@section('title', 'إضافة كتاب')

@section('content')
	<section class="card">
		<div class="card-header">
			<div>
				<h1 class="card-title">إضافة كتاب</h1>
				<p class="page-subtitle">أدخل بيانات الكتاب بدقة.</p>
			</div>
			<a class="btn btn-secondary" href="{{ route('books.index') }}">رجوع</a>
		</div>

		<form class="form-grid" action="{{ route('books.store') }}" method="POST">
			@csrf

			<div class="field field-full">
				<label for="title">العنوان</label>
				<input id="title" type="text" name="title" value="{{ old('title') }}" required>
				@error('title')<p class="field-error">{{ $message }}</p>@enderror
			</div>

			<div class="field">
				<label for="author_id">المؤلف</label>
				<select id="author_id" name="author_id" required>
					<option value="">اختر مؤلف</option>
					@foreach($authors as $author)
						<option value="{{ $author->id }}" @selected(old('author_id') == $author->id)>{{ $author->name }}</option>
					@endforeach
				</select>
				@error('author_id')<p class="field-error">{{ $message }}</p>@enderror
			</div>

			<div class="field">
				<label for="category_id">التصنيف</label>
				<select id="category_id" name="category_id" required>
					<option value="">اختر تصنيف</option>
					@foreach($categories as $category)
						<option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
					@endforeach
				</select>
				@error('category_id')<p class="field-error">{{ $message }}</p>@enderror
			</div>

			<div class="field">
				<label for="published_year">سنة النشر</label>
				<input id="published_year" type="number" name="published_year" value="{{ old('published_year') }}" min="1000" max="{{ date('Y') }}" required>
				@error('published_year')<p class="field-error">{{ $message }}</p>@enderror
			</div>

			<div class="field">
				<label for="pages">عدد الصفحات</label>
				<input id="pages" type="number" name="pages" value="{{ old('pages') }}" min="1" required>
				@error('pages')<p class="field-error">{{ $message }}</p>@enderror
			</div>

			<div class="field">
				<label for="price">سعر الكتاب</label>
				<input id="price" type="number" step="0.01" min="0" name="price" value="{{ old('price', 0) }}" required>
				@error('price')<p class="field-error">{{ $message }}</p>@enderror
			</div>

			<div class="field field-full">
				<label>
					<input type="checkbox" name="available" value="1" @checked(old('available', true))>
					متاح للاستعارة
				</label>
			</div>

			<div class="actions field-full">
				<button class="btn btn-primary" type="submit">حفظ</button>
				<a class="btn btn-secondary" href="{{ route('books.index') }}">إلغاء</a>
			</div>
		</form>
	</section>
@endsection
