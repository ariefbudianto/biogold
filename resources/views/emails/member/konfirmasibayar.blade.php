<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body> 
		Hai ADMIN,
		<br /><br />
		Ada konfirmasi pembayaran registrasi di BIOGOLD:<br />
		<p>
		<table>
			<tr><td>Jumlah Transfer</td><td>: {{ $jml_transfer }}</td></tr>
			<tr><td>Bank Tujuan</td><td>: {{ $rek_tujuan }}</td></tr>			
			<tr><td colspan="2" style="font-weight:bold;">MEMBER INFO</td></tr>
			<tr><td>Username</td><td>: {{ $user_username }}</td></tr>			
			<tr><td>Nama</td><td>: {{ $user_name }}</td></tr>	
			<tr><td>Email</td><td>: {{ $user_email }}</td></tr>				
			<tr><td colspan="2" style="font-weight:bold;">REKENING PENGIRIM</td></tr>
			<tr><td>Nomor Rekening</td><td>: {{ $rek_no }}</td></tr>
			<tr><td>Atas Nama</td><td>: {{ $rek_nama }}</td></tr>
			<tr><td>Bank Pengirim</td><td>: {{ $rek_bank }}</td></tr>
		</table>
		</p>
		<p>Harap segera di cek dan dikonfirmasi pelunasan bilamana pembayaran telah diterima.
		</p>
	</body>
</html>
