<!DOCTYPE html>
<html class="app">
    <head>
        <title>@yield('title')</title>
    	<meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- CSS ASSETS -->
        @foreach($data['css_assets'] as $key => $asset)
            {!! HTML::style($asset) !!}
        @endforeach
    </head>
    <body>
        @yield('content')
        <!-- JS ASSETS -->
        @foreach($data['js_assets'] as $key => $asset)
            {!! HTML::script($asset) !!}
        @endforeach
        @include('app/components/app_js')
        @yield('script')
    </body>
</html>