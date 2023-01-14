<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	@include('layouts.head')
	<body>
		@include('layouts.sidebar')
		<div class="content-wrapper">
			@yield('content')
		</div>
		
		@include('layouts.footer')
		@include('layouts.script')
	</body>
</html>

