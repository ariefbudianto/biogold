@extends('app.components.layout')

@section('title', $data['title'])

@section('content')
    <section class="vbox">
        <header class="bg-primary header header-md navbar navbar-fixed-top-xs box-shadow">
            <div class="navbar-header aside-md dk">
                <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav">
                    <i class="fa fa-bars"></i>
                </a>
                <a href="{!! URL::to('app/home') !!}" class="navbar-brand">
                    <span class="hidden-nav-xs app-title">Biogold</span>
                </a>
                <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user">
                    <i class="fa fa-cog"></i>
                </a>
            </div>
            <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="thumb-sm avatar pull-left">
                            <img src="{!! asset('assets/app/images/a1.png') !!}" alt="..." width="128px" height="128px">
                        </span>
                        {!! $data['active_user'] !!} <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight">
                        <li>
                            <a href="{!! URL::to('app/signout') !!}">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </header>
        <section>
            <section class="hbox stretch">
                <!-- .aside -->
                <aside class="bg-dark aside-md hidden-print" id="nav">
                    <section class="vbox">
                        <section class="w-f scrollable">
                            <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
                                @include('app/components/menu')
                            </div>
                        </section>
                        <footer class="footer hidden-xs no-padder text-center-nav-xs">
                            <a href="#nav" data-toggle="class:nav-xs" class="btn btn-icon icon-muted btn-inactive m-l-xs m-r-xs">
                                <i class="i i-circleleft text"></i>
                                <i class="i i-circleright text-active"></i>
                            </a>
                        </footer>
                    </section>
                </aside>
                <!-- /.aside -->
                <section id="content">
                    <section class="hbox stretch">
                        <section class="vbox">
                            <section class="scrollable padder">
                                {!! $content !!}
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
@stop

@section('script')
    
@stop