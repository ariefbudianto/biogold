<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body> 
		Hai, {{ $name }} Terima kasih telah mendaftar di BioGold
		<br /><br />
		Berikut ini adalah data-data yang masuk ke database saat registrasi.<br />
		Untuk username dan password dibuat secara otomatis oleh sistem, dimana password bisa diubah di dalam MEMBER AREA.<br />
		Email dan password diperlukan untuk login ke MEMBER AREA Biogold.
		<table>
			<tr><td>N a m a </td><td>{{ $name }}</td></tr>
			<tr><td>Email</td><td>{{ $email }}</td></tr>
			<tr><td>Username</td><td>{{ $username }}</td></tr>
			<tr><td>Password</td><td>{{ $password }}</td></tr>
			<tr><td>Handphone</td><td>{{ $handphone }}</td></tr>
		</table>
		<div>Untuk mengaktifkan akun Anda, silahkan klik link berikut: <br>
		<a target="_blank" href="{{ url('/aktifasi/'. $activationCode.'/'.$id) }}">{{ url('/aktivasi/'. $activationCode.'/'.$id) }}</a>
		</div>
	</body>
</html>
