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
			<a class="brand" href="{{ route('books.index') }}">Library Hub</a>
			<nav class="nav-links">
				<a class="btn btn-secondary" href="{{ route('books.index') }}">كل الكتب</a>
				<a class="btn btn-primary" href="{{ route('books.create') }}">إضافة كتاب</a>
			</nav>
		</header>

		@if (session('success'))
			<div class="alert alert-success">{{ session('success') }}</div>
		@endif

		@if (session('error'))
			<div class="alert alert-error">{{ session('error') }}</div>
		@endif

		@yield('content')
	</div>
</body>
</html>
