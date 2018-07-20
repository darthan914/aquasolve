<!DOCTYPE html>
<html>
<head>
	<title>Aquasolve Careers</title>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
<body>

<ul>
	<li>Name: {{ $name }}</li>
	<li>Email: {{ $email }}</li>
	<li>Phone: {{ $telp }}</li>
	<li>Position: {{ $position }}</li>
</ul>

<div>{!! $bodyMessage !!}</div>

<p>File : <a href="{{ asset($file) }}">Download</a></p>

</body>
</html>