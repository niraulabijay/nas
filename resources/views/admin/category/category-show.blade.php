<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>category name</title>
</head>
<body>
	<ul>
		@foreach($categories as $cat)
			<li>{{ $cat->name }}
				@include('admin.category.menu')
			</li>
		@endforeach
	</ul>
</body>
</html>