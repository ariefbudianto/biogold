<html lang="en">
	<head>
		<title>BioGold Template</title>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<nav id="nav_menu">
						<ul>
							<li class='active'>
								<a href="{{url('/')}}" title="Halaman utama"><i class="fa fa-home"></i> Home</a>
							</li>
							<li><a href="{{url('produk')}}"><i class="fa fa-box"></i> Products</a></li>
							<li><a href="{{url('register')}}"><i class="fa fa-pencil-square"></i> Register</a></li>
							<li><a href="{{url('login')}}"><i class="fa fa-sign-in"></i> Login</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">	
					<h1>BioGold</h1>
					@yield('content')
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">	
					<h4>FOOTER</h4>
					<div>Diperkenalkan oleh {{ $sponsor }}</div>
				</div>
			</div>
		</div> 
	</body>
</html>