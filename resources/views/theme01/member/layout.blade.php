<html lang="en">
	<head>
		<title>BioGold MEMBER AREA</title>
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
			        <li><a href="{{ URL::route('user.profile') }}">Profile <span class="sr-only">(current)</span></a></li>
			        <li><a href="{{ URL::route('user.confirmpayment') }}">Konfirmasi Pembayaran</a></li>
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Data <span class="caret"></span></a>
			          <ul class="dropdown-menu" role="menu">
			            <li><a href="{{ URL::route('user.referral') }}">Referral</a></li>
			          </ul>
			        </li>
			      </ul>
			      <ul class="nav navbar-nav navbar-right">
			        <li><a href="{{ URL::route('user.logout') }}">LOGOUT</a></li>
			      </ul>
			    </div>
			  </div>
			</nav>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">	
					<div class="jumbotron">
					@yield('content')
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">	
					<div style="color:#FFF">BioGold :: MEMBER AREA</div>
				</div>
			</div>
		</div>
		@section('includejs')
		@show
	</body>
	<style>
	body{
	  background: url("../images/stardust.png");
	}
	</style>	
	<script type="text/javascript">
	@section('javascript')
        var url = window.location;
		// Will only work if string in href matches with location
		$('#menuBio ul.nav a[href="'+ url +'"]').parent().addClass('active');

		// Will also work for relative and absolute hrefs
		$('#menuBio ul.nav a').filter(function() {
		    return this.href == url;
		}).parent().addClass('active');
    @show		
	</script>
</html>