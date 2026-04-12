@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
    <section class="card auth-login-card">
        <div class="card-header">
            <div>
                <h1 class="card-title">تسجيل الدخول</h1>
                <p class="page-subtitle">ادخل بريدك وكلمة المرور للوصول إلى المنصة.</p>
            </div>
        </div>

        <form class="form-grid" action="{{ route('login') }}" method="POST">
            @csrf

            <div class="field field-full">
                <label for="email">البريد الإلكتروني</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="field field-full">
                <label for="password">كلمة المرور</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div class="field field-full">
                <label>
                    <input type="checkbox" name="remember" value="1">
                    تذكرني
                </label>
            </div>

            <div class="actions field-full">
                <button class="btn btn-primary" type="submit">دخول للمنصة</button>
                <a class="btn btn-secondary" href="{{ route('register.form') }}">إنشاء حساب</a>
            </div>
        </form>
    </section>
@endsection
