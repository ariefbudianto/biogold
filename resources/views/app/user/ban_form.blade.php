<!-- Page Subtitle -->
<header class="panel-heading">{{ $data['page_subtitle'] }}</header>

<div class="panel-body">

	<!-- Content -->
	<div class="col-sm-12 form-inline" id='message'></div>

</div>

<footer class="panel-footer">
	<div class="row">

		<!-- Confirmation Button -->
		<div class="form-group">
			<div class="col-sm-4">
				<button type="button" class="btn btn-primary action" title="yes" onclick="ban_routes('yes')">Yes</button>
				<button type="button" class="btn btn-default action" title="no" onclick="ban_routes('no')">No</button>
			</div>
		</div>

	</div>
</footer>

<script type="text/javascript">

	var index = "{{ $data['index'] }}";
	var row = datagrid.getRowData(index);
	var onLoad = (function() {
		$('.loading-panel').hide();
		$('.form-panel').show();
		
		if(row['activated'] == 'Banned'){
			$('#message').html('Are you sure want to UnBan this user ?');
		} else {
			$('#message').html('Are you sure want to Ban this user ?');
		}
	})();

	function ban_data() {
		$('.form-group').disable([".action"]);
		if(row['activated'] == 'Banned'){
			$("button[title='yes']").html("UnBan the User, please wait...");
		} else {
			$("button[title='yes']").html("Ban the User, please wait...");
		}
		
		$.post("{{ URL::to('app/user/ban') }}", {id : row['id']}).done(function(data) {
            $('.datagrid-panel').fadeIn();
			$('.form-panel').fadeOut();
			datagrid.reload();
        });
	}

	function cancel() {
		$('.datagrid-panel').fadeIn();
		$('.form-panel').fadeOut();
	}

	function ban_routes(action) {
		action == 'yes' ? ban_data() : cancel();
	}

</script>