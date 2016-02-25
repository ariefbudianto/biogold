<nav class="nav-primary hidden-xs">
	<div class="text-muted text-sm hidden-nav-xs padder m-t-sm m-b-sm">Menu</div>
	<ul class="nav nav-main" data-ride="collapse">
		@foreach ($data['list_menu'] as $menu)
			@if ($menu->parent_id == 0)
				<li class="{!! $data['active_menu'] == $menu->id ? 'active' : '' !!}">
					<a href="javascript:void(0);" class="auto">
						<span class="pull-right text-muted">
							<i class="i i-circle-sm-o text"></i>
							<i class="i i-circle-sm text-active"></i>
						</span>
						<i class="{!! $menu->icon !!}"></i>
						<span class="font-bold"> {!! $menu->title !!} </span>
					</a>
					<ul class="nav dk">
						<!-- Loop submenu -->
						@foreach ($data['list_menu'] as $submenu)
						@if ($submenu->parent_id == $menu->id)
						<li>
							<a href="{!! URL::to($submenu->link) !!}" class="auto">                       
								<i class="i i-dot"></i>
								<span> {!! $submenu->title !!} </span>
							</a>
						</li>
						@endif
						@endforeach
					</ul>
				</li>
			@endif
		@endforeach
	</ul>
</nav>

