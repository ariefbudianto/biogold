<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body> 
		<h2>Hai, {{ $name }} Terima kasih telah mendaftar di BioGold</h2>
		<br />
		Berikut ini adalah data yang Anda masukkan saat registrasi dan dipakai untuk login ke MEMBER AREA Biogold.
		<table>
			<tr><td>N a m a </td><td>{{ $name }}</td></tr>
			<tr><td>Email</td><td>{{ $email }}</td></tr>
		</table>
		<div>Untuk mengaktifkan akun Anda, silahkan klik link berikut: <br>
		<a target="_blank" href="{{ url('/register/aktivasi/'. $activationCode) }}">{{ url('/register/aktivasi/'. $activationCode) }}</a>
		</div>
	</body>
</html>
