<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body> 
		Hai {{ $name }},
		<br /><br />
		Ada permintaan reset password dari {{ $name }}.<br />
		<p>Silahkan klik link berikut untuk memasukkan password baru:<br />
		<a target="_blank" href="{{ route('user.passwordnew',['id' => $id, 'code' => $code]) }}">{{ route('user.passwordnew',['id' => $id, 'code' => $code]) }}</a>
		</p>
		<p>Abaikan email ini bila {{ $name }} tidak merasa melakukan permintaan reset password.
	</body>
</html>
