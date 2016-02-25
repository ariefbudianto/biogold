<!-- Page Title -->
<div class="m-b-md">
	<h3 class="m-b-xs text-black"><i class="fa fa-user"></i> {{ $data['page_title'] }}</h3>
</div>

<!-- Datagrid Panel -->
<section class="scrollable">
	<div class="row">
		<header class="panel-heading">{{ $data['page_subtitle'] }}</header>   
		<div class="col-sm-4">
			<div class="list-group bg-dark auto">

				<!-- Loop group list -->
	    		@foreach ($data['groups'] as $group)
					<a href="javascript:void(0)" class="list-group-item" id="{{ $group->id }}">
						<i class="fa fa-chevron-right icon-muted"></i>
						<i class="fa fa-eye icon-muted fa-fw"></i> {{ $group->name }}
					</a>
				@endforeach

			</div>
		</div>
		<div class="col-sm-8">
			<section class="panel panel-default">

				<header class="panel-heading tree-header">List Menu</header>
				<table class="table table-striped tree">

					<tr class="treegrid-app">
	                    <td><input type="checkbox" id="checkbox-app"> Access to App</td>
	                </tr>

					<!-- Loop menu -->
    				@foreach ($data['menus'] as $menu)
    					@if ($menu->parent_id == 0)

			                <tr class="treegrid-menu-{{ $menu->id }}">
			                    <td><input type="checkbox" id="checkbox-menu-{{ $menu->id }}"> {{ $menu->title }}</td>
			                </tr>

			                <!-- Loop submenu -->
				            @foreach ($data['menus'] as $submenu)
				              @if ($submenu->parent_id == $menu->id)

				                <tr class="treegrid-menu-{{ $submenu->id }} treegrid-parent-menu-{{ $menu->id }}">
				                    <td><input type="checkbox" id="checkbox-menu-{{ $submenu->id }}"> {{ $submenu->title }}</td>
				                </tr>

				              @endif
				            @endforeach

						@endif
		        	@endforeach

	            </table>
			</section>
		</div>
	</div>
</section>

@section('script')
	@parent
	<script type="text/javascript">
		$(document).ready(function() {
			var role_id, arrId = [];

	        $('.tree').treegrid({
	            expanderExpandedClass: 'fa fa-folder-open',
	            expanderCollapsedClass: 'fa fa-folder' 
	        });

			$(".tree input[type='checkbox']").click(function() {
				var checked = $(this).is(':checked');
				if (checked) {
					if ($(this).closest('tr').treegrid('getParentNode') != null) {
						$(this).closest('tr').treegrid('getParentNode').find(":checkbox").prop('checked',true);
					}
					if ($(this).closest('tr').treegrid('getChildNodes') != null) {
						$(this).closest('tr').treegrid('getChildNodes').find(":checkbox").prop('checked',true);
					}
				} else {
					if ($(this).closest('tr').treegrid('getChildNodes') != null) {
						$(this).closest('tr').treegrid('getChildNodes').find(":checkbox").prop('checked',false);
					}
				}
			});

			$("input[type='checkbox']").each(function() {
				$(this).on("click", function() {
					var arrPush = {};
					$("input[type='checkbox']").each(function() {
						var key = this.id.substr(9);
						if ($(this).is(':checked')) {
							arrPush[key] = true;
						} else {
							arrPush[key] = false;
						}
					});
					$.post("{{ url('app/privilege/action') }}", {role_id: role_id, arr_id: JSON.stringify(arrPush)});
				});
			});

			$(".list-group-item").each(function() {
				$(this).on("click", function() {
					role_id = this.id;
					$("input[type='checkbox']").each(function() {
						$(this).prop('checked', false);
					});
					$.post("{{ url('app/privilege/load') }}", {role_id: this.id}).done(function(data) {
						console.log(data);
						for (var i = 0; i < data.length; i++) {
							$("#checkbox-" + data[i]).prop('checked', true);
						}
			        });
				});
			});
	    });
	    
	</script>
@stop