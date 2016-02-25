<header class="panel-heading">{{ $data['page_subtitle'] }}</header>

<div class="panel-body">
	<form class="form-horizontal" id="form-action">

		<div class="form-group hidden">
			<div class="col-sm-12">
				<input type="text" name="id" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label">Nama Group</label>
			<div class="col-sm-9">
				<input type="text" name="name" class="form-control">
			</div>
		</div>

		<div class="line line-dashed b-b line-lg pull-in"></div>

		<div class="form-group">
			<div class="col-sm-4 col-sm-offset-2">
				<button type="button" class="btn btn-default action" title="cancel" onclick="form_routes('cancel')">Cancel</button>
				<button type="button" class="btn btn-primary action" title="save" onclick="form_routes('save')">Save changes</button>
			</div>
		</div>

	</form>
</div>

<script type="text/javascript">

	var onLoad = (function() {
		var index = "{{ $data['index'] }}";
		
		if (index != '') {
			var row = datagrid.getRowData(index);
			$('#form-action').formLoad(row);
		}

		$('.loading-panel').hide();
		$('.form-panel').show();
	})();

	function validate(formData) {
		var returnData;

		$('#form-action').disable([".action"]);
		$("button[title='save']").html("Validating data, please wait...");

		$.ajax({
	        url: "{{ url('app/group/validate') }}", async: false, type: 'POST', data: formData,
	        success: function(data, textStatus, jqXHR) {
				returnData = data;
	        }
	    });

        if (returnData != 'success') {
        	$('#form-action').enable([".action"]);
			$("button[title='save']").html("Save changes");
			$('#form-action').validate(returnData, 'parsley-error', 'help-block');
        } else {
		    return 'success';	
        }
	}

	function save(formData) {
		$("button[title='save']").html("Saving data, please wait...");
		$.post("{{ url('app/group/action') }}", formData).done(function(data) {
        	$('.datagrid-panel').fadeIn();
			$('.form-panel').fadeOut();
			datagrid.reload();
        });
	}

	function cancel() {
		$('.datagrid-panel').fadeIn();
		$('.form-panel').fadeOut();
	}

	function form_routes(action) {
		if (action == 'save') {
			var formData = $('#form-action').serialize();
			if (validate(formData) == 'success') {
				save(formData);
			}
		} else {
			cancel();
		}
	}

</script>