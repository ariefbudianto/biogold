@extends('components/layout')

@section('title', $data['title'])

@section('content')
    <section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
        <div class="container aside-xl">
            <a class="navbar-brand block app-title" href="">Biogold</a>
            <section class="m-b-lg">
                <header class="wrapper text-center">
                    <strong>Please log on to continue</strong>
                </header>
                <form name="signin" id="form-signin" method="post">
                    <div class="list-group">
                        <div class="list-group-item">
                            <input type="text" placeholder="Email..." name="email" class="text-center form-control no-border">
                        </div>
                        <div class="list-group-item">
                            <input type="password" placeholder="Password..." name="password" class="text-center form-control no-border">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary btn-block" id="sign-in">Sign in</button>
                </form>
            </section>
        </div>
    </section>
    <!-- footer -->
    <footer id="footer">
        <div class="text-center padder">
            <p>
                <small>Biogold.com &copy; 2015</small>
            </p>
        </div>
    </footer>
@stop


@section('script')
    @parent
    <script type="text/javascript">
        $('#form-signin').on("submit", function(event) {
            event.preventDefault();
            var data = $('#form-signin').serialize();
            $.post("{!! url('app/signin') !!}", data).done(function(data) {
                if (data != "Login Success") {
                    $('#form-signin').validate(data, 'input-error');
                } else {
                    window.location.replace("{!! url('app') !!}");
                }
            });
        });
    </script>
@stop