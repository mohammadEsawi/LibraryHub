@extends('layouts.app')

@section('title', 'إرسال طلب بيع كتاب')

@section('content')
    <section class="card">
        <div class="card-header">
            <div>
                <h1 class="card-title">طلب بيع كتاب للموقع</h1>
                <p class="page-subtitle">سيتم مراجعة الطلب من إدارة المنصة.</p>
            </div>
            <a class="btn btn-secondary" href="{{ route('author-submissions.index') }}">طلباتي</a>
        </div>

        <form class="form-grid" action="{{ route('author-submissions.store') }}" method="POST">
            @csrf

            <div class="field field-full">
                <label for="title">عنوان الكتاب</label>
                <input id="title" type="text" name="title" value="{{ old('title') }}" required>
            </div>

            <div class="field">
                <label for="category_id">التصنيف</label>
                <select id="category_id" name="category_id" required>
                    <option value="">اختر تصنيف</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="published_year">سنة النشر</label>
                <input id="published_year" type="number" name="published_year" value="{{ old('published_year') }}" min="1000" max="{{ date('Y') }}">
            </div>

            <div class="field">
                <label for="pages">عدد الصفحات</label>
                <input id="pages" type="number" name="pages" value="{{ old('pages', 1) }}" min="1" required>
            </div>

            <div class="field">
                <label for="proposed_price">السعر المقترح</label>
                <input id="proposed_price" type="number" name="proposed_price" step="0.01" min="0" value="{{ old('proposed_price', 0) }}" required>
            </div>

            <div class="field field-full">
                <label for="description">وصف مختصر</label>
                <textarea id="description" name="description" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="actions field-full">
                <button class="btn btn-primary" type="submit">إرسال الطلب</button>
                <a class="btn btn-secondary" href="{{ route('books.index') }}">إلغاء</a>
            </div>
        </form>
    </section>
@endsection
