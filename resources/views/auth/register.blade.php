@extends('layouts.app')

@section('title', 'إنشاء حساب')

@section('content')
    <section class="card" style="max-width: 560px; margin-inline: auto;">
        <div class="card-header">
            <div>
                <h1 class="card-title">إنشاء حساب جديد</h1>
                <p class="page-subtitle">اختر نوع الحساب المناسب.</p>
            </div>
        </div>

        <form class="form-grid" action="{{ route('register') }}" method="POST">
            @csrf

            <div class="field field-full">
                <label for="name">الاسم</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="field field-full">
                <label for="email">البريد الإلكتروني</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="field">
                <label for="password">كلمة المرور</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div class="field">
                <label for="password_confirmation">تأكيد كلمة المرور</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <div class="field field-full">
                <label for="role">نوع المستخدم</label>
                <select id="role" name="role" required>
                    <option value="customer" @selected(old('role') === 'customer')>مستخدم عادي (مشتري)</option>
                    <option value="reader" @selected(old('role') === 'reader')>قارئ</option>
                    <option value="author" @selected(old('role') === 'author')>مؤلف</option>
                </select>
            </div>

            <div class="actions field-full">
                <button class="btn btn-primary" type="submit">إنشاء حساب</button>
                <a class="btn btn-secondary" href="{{ route('login.form') }}">لدي حساب</a>
            </div>
        </form>
    </section>
@endsection
