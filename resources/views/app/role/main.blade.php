<!-- Page Title -->
<div class="m-b-md">
	<h3 class="m-b-xs text-black"><i class="fa fa-user"></i> {{ $data['page_title'] }}</h3>
</div>

<!-- Loading Image -->
<section class="panel panel-default loading-panel">
	<header class="panel-heading">Loading Content</header>
	<div class="panel-body">
		<div class="loading-content"></div>
	</div>
</section>

<!-- Form Panel -->
<section class="panel panel-default form-panel"></section>

<!-- Datagrid Panel -->
<section class="panel panel-default datagrid-panel">

	<!-- Page Subtitle -->
	<header class="panel-heading">{{ $data['page_subtitle'] }}</header>
	<div class="row wrapper">

		<!-- Add Button -->
		<div class="col-sm-1 form-inline">
			<div class="form-group">
				<div class="col-lg-10">
					<button type="button" class="btn btn-sm btn-success btn-add" onclick="main_routes('create', '')">
						<i class="fa fa-plus"></i>
						<span>New Group</span>
					</button>
				</div>
			</div>
		</div>

		<div class="col-sm-7 form-inline"></div>

		<!-- Search -->
		<div class="col-sm-4 form-inline">
			<div class="form-group">
				<select class="input-sm form-control input-s-sm inline v-middle option-search" id="search-option"></select>
			</div>
			<div class="form-group">
				<input type="text" class="input-sm form-control" placeholder="Search" id="search">
			</div>
		</div>

	</div>

	<!-- Datagrid -->
	<div class="table-responsive">
		<table class="table table-striped b-t b-light" id="datagrid"></table>
	</div>

	<footer class="panel-footer">
		<div class="row">

			<!-- Page Option -->
			<div class="col-sm-4 hidden-xs">
				<select class="input-sm form-control input-s-sm inline v-middle option-page" id="option"></select>
			</div>

			<!-- Page Info -->
			<div class="col-sm-3 text-center">
				<small class="text-muted inline m-t-sm m-b-sm" id="info"></small>
			</div>

			<!-- Paging -->
			<div class="col-sm-5 text-right text-center-xs">
				<ul class="pagination pagination-sm m-t-none m-b-none" id="paging"></ul>
			</div>

		</div>
	</footer>

</section>

@section('script')
	@parent
<script type="text/javascript">
	var datagrid;
	$(document).ready(function() {

		datagrid = $("#datagrid").datagrid({
			url						: "{{ url('app/group/data') }}",
			primaryField			: 'id', 
			rowNumber				: true, 
			rowCheck 				: false, 
			searchInputElement 		: '#search', 
			searchFieldElement 		: '#search-option', 
			pagingElement 			: '#paging', 
			optionPagingElement 	: '#option', 
			pageInfoElement 		: '#info',
			columns					: [
	        	{field: 'name', title: 'Nama Group', editable: false, sortable: true, width: 650, align: 'left', search: true},
	        	{field: 'menu', title: 'Menu', sortable: false, width: 200, align: 'center', search: false, 
	        		rowStyler: function(rowData, rowIndex) {
	        			return menu(rowData, rowIndex);
	        		}
	        	}
	        ]
		});

		datagrid.run();
	});

	function menu(rowData, rowIndex) {
		var menu = 
			'<div class="btn-group">' + 
				'<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></a>' +
				'<ul class="dropdown-menu pull-right">' +
					'<li onclick="main_routes(\'update\', ' + rowIndex + ')"><a href="javascript:void(0);"><i class="fa fa-pencil"></i> Edit</a></li>' +
					'<li onclick="main_routes(\'delete\', ' + rowIndex + ')"><a href="javascript:void(0);"><i class="fa fa-trash-o"></i> Delete</a></li>' +
				'</ul>' +
			'</div>';
		return menu;
	}

	function create_update_form(rowIndex) {
		$.post("{{ url('app/group/form') }}", {index : rowIndex}).done(function(data) {
			$('.form-panel').html(data);
        });
	}

	function delete_form(rowIndex) {
		$.post("{{ url('app/group/delete_form') }}", {index : rowIndex}).done(function(data) {
			$('.form-panel').html(data);
        });
	}

	function main_routes(action, rowIndex) {
		$('.datagrid-panel').fadeOut();
		$('.loading-panel').fadeIn();

		if (action == 'create') {
			create_update_form(rowIndex);
		} else if (action == 'update') {
			create_update_form(rowIndex);
		} else {
			delete_form(rowIndex);
		}
	}

</script>
@stop