<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Library Hub') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="page">
        <section class="card card-welcome">
            <h1 class="card-title">مرحباً بك في Library Hub</h1>
            <p class="page-subtitle section-gap">منصة لإدارة الكتب والقراءة والبيع بشكل احترافي.</p>

            @if (Route::has('login'))
                <div class="actions actions-center section-gap">
                    @auth
                        <a class="btn btn-primary" href="{{ route('books.index') }}">الدخول إلى المكتبة</a>
                    @else
                        <a class="btn btn-secondary" href="{{ route('login.form') }}">تسجيل الدخول</a>
                        @if (Route::has('register.form'))
                            <a class="btn btn-primary" href="{{ route('register.form') }}">إنشاء حساب</a>
                        @endif
                    @endauth
                </div>
            @endif
        </section>
    </div>
</body>
</html>
