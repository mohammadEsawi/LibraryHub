<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title', 'Library Hub')</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
	<div class="page">
		<header class="top-nav">
			<a class="brand" href="{{ auth()->check() ? route('books.index') : route('login.form') }}">Library Hub</a>
			<nav class="nav-links">
				@auth
					<a class="btn btn-secondary" href="{{ route('books.index') }}">كل الكتب</a>
				@endauth

				@auth
					@if (auth()->user()->role === 'admin')
						<a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">لوحة الأدمن</a>
						<a class="btn btn-secondary" href="{{ route('admin.activity-log') }}">Activity Log</a>
						<a class="btn btn-primary" href="{{ route('books.create') }}">إضافة كتاب</a>
						<a class="btn btn-secondary" href="{{ route('admin.submissions.index') }}">طلبات المؤلفين</a>
					@endif

					@if (auth()->user()->role === 'author')
						<a class="btn btn-primary" href="{{ route('author-submissions.create') }}">بيع كتاب</a>
						<a class="btn btn-secondary" href="{{ route('author-submissions.index') }}">طلباتي</a>
					@endif

					<form action="{{ route('logout') }}" method="POST">
						@csrf
						<button class="btn btn-danger" type="submit">تسجيل خروج</button>
					</form>
				@else
					<a class="btn btn-secondary" href="{{ route('login.form') }}">تسجيل دخول</a>
					<a class="btn btn-primary" href="{{ route('register.form') }}">إنشاء حساب</a>
				@endauth
			</nav>
		</header>

		@if (session('success'))
			<div class="alert alert-success">{{ session('success') }}</div>
		@endif

		@if (session('error'))
			<div class="alert alert-error">{{ session('error') }}</div>
		@endif

		@if ($errors->any())
			<div class="alert alert-error">
				{{ $errors->first() }}
			</div>
		@endif

		@yield('content')

		<footer class="site-footer">
			<p>Library Hub Platform</p>
			<p>نظام كامل لإدارة الكتب، القراءة، البيع، والمشتريات</p>
		</footer>
	</div>

	@stack('scripts')
</body>
</html>
