<html lang="en">
	<head>
		<title>BioGold</title>
		<link rel="stylesheet" type="text/css" href="{{ asset("css/styles.css") }}">
		<script src="{{ asset("js/app.js") }}"></script>
	</head>
	<body>
		<div class="container">
			<nav class="navbar navbar-default">
			  <div class="container-fluid">
			    <div class="navbar-header">
			      <button aria-expanded="false" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menuBio">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			      <a class="navbar-brand" href="{{url('/')}}">BioGOLD</a>
			    </div>

			    <div style="height: 1px;" aria-expanded="false" class="navbar-collapse collapse" id="menuBio">
			      <ul class="nav navbar-nav">
			        <li><a href="{{ URL::route('public.index') }}">Homepage <span class="sr-only">(current)</span></a></li>
			        <li><a href="{{ URL::route('public.products') }}">Produk</a></li>
			        <li><a href="{{ URL::route('user.signup') }}">Registrasi</a></li>
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">FAQ <span class="caret"></span></a>
			          <ul class="dropdown-menu" role="menu">
			            <li><a href="#">Cara Pendaftaran</a></li>
			            <li class="divider"></li>
			            <li><a href="#">Pembayaran</a></li>
			            <li><a href="#">Legalitas</a></li>
			          </ul>
			        </li>
			      </ul>
			      <form class="navbar-form navbar-left" role="search">
			        <div class="form-group">
			          <input vk_1b39c="subscribed" class="form-control" placeholder="Cari produk" type="text">
			        </div>
			        <button type="submit" class="btn btn-default">GO</button>
			      </form>
			      <ul class="nav navbar-nav navbar-right">
			        <li><a href="{{ URL::route('user.login') }}">LOGIN</a></li>
			      </ul>
			    </div>
			  </div>
			</nav>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">	
					
					@yield('content')
					
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">	
					<div style="color:#FFF">Diperkenalkan oleh {{ $sponsor }}</div>
				</div>
			</div>
		</div> 
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
	</body>
	<style>
	body{
	  background: url("images/stardust.png");
	}
	.container .jumbotron {
		background-color: ##4e5d6c;
	}
	</style>
	<script type="text/javascript">
		var url = window.location;
		// Will only work if string in href matches with location
		$('#menuBio ul.nav a[href="'+ url +'"]').parent().addClass('active');

		// Will also work for relative and absolute hrefs
		$('#menuBio ul.nav a').filter(function() {
		    return this.href == url;
		}).parent().addClass('active');
	</script>
</html>