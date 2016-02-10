<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body> 
		<h2>Selamat datang di Biogold</h2>
		<div>Untuk mengaktifkan akun Anda, silahkan klik link berikut: <br>
		{{ link_to_route('user.activate', null, ['email'=>$email, 'activationCode'=>$a\ 12 ctivationCode]) }}
		</div>
	</body>
</html>
