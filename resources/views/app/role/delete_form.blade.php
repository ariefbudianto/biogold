<!-- Page Subtitle -->
<header class="panel-heading">{{ $data['page_subtitle'] }}</header>

<div class="panel-body">

	<!-- Content -->
	<div class="col-sm-12 form-inline">
		Are you sure want to delete this item?
	</div>

</div>

<footer class="panel-footer">
	<div class="row">

		<!-- Confirmation Button -->
		<div class="form-group">
			<div class="col-sm-4">
				<button type="button" class="btn btn-primary action" title="yes" onclick="delete_routes('yes')">Yes</button>
				<button type="button" class="btn btn-default action" title="no" onclick="delete_routes('no')">No</button>
			</div>
		</div>

	</div>
</footer>

<script type="text/javascript">

	var index = "{{ $data['index'] }}";

	var onLoad = (function() {
		$('.loading-panel').hide();
		$('.form-panel').show();
	})();

	function delete_data() {
		$('.form-group').disable([".action"]);
		$("button[title='yes']").html("Deleting data, please wait...");

		var row = datagrid.getRowData(index);

		$.post("{{ URL::to('app/group/delete') }}", {id : row['id']}).done(function(data) {
            $('.datagrid-panel').fadeIn();
			$('.form-panel').fadeOut();
			datagrid.reload();
        });
	}

	function cancel() {
		$('.datagrid-panel').fadeIn();
		$('.form-panel').fadeOut();
	}

	function delete_routes(action) {
		action == 'yes' ? delete_data() : cancel();
	}

</script>