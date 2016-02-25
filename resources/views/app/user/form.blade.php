<header class="panel-heading">{{ $data['page_subtitle'] }}</header>

<div class="panel-body">
	<form class="form-horizontal" id="form-action">

		<div class="form-group hidden">
			<div class="col-sm-12">
				<input type="text" name="id" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label">Nama Depan</label>
			<div class="col-sm-9">
				<input type="text" name="first_name" class="form-control">
			</div>
		</div>

		<div class="line line-dashed b-b line-lg pull-in"></div>

		<div class="form-group">
			<label class="col-sm-2 control-label">Nama Belakang</label>
			<div class="col-sm-9">
				<input type="text" name="last_name" class="form-control">
			</div>
		</div>

		<div class="line line-dashed b-b line-lg pull-in"></div>

		<div class="form-group">
			<label class="col-sm-2 control-label">Email</label>
			<div class="col-sm-9">
				<input type="text" name="email" class="form-control">
			</div>
		</div>

		<div class="line line-dashed b-b line-lg pull-in"></div>

		<div class="form-group">
			<label class="col-sm-2 control-label">Password</label>
			<div class="col-sm-9">
				<input type="password" name="password" class="form-control">
			</div>
		</div>

		<div class="line line-dashed b-b line-lg pull-in"></div>

		<div class="form-group">
			<label class="col-sm-2 control-label">Nomor Telepon</label>
			<div class="col-sm-9">
				<input type="text" name="handphone" class="form-control">
			</div>
		</div>

		<div class="line line-dashed b-b line-lg pull-in"></div>

		<div class="form-group">
			<label class="col-lg-2 control-label">Group</label>
			<div class="col-lg-9">
				<select name="role_id" class="form-control chosen-select" style="width: 100%;">
					@foreach ($data['roles'] as $role)
						<option value="{{ $role->id }}">{{ $role->name }}</option>
					@endforeach
				</select>
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
	        url: "{{ url('app/user/validate') }}", 
	        type: 'POST', 
	        dataType: 'json',
	        data: formData,
	        async: false,
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
		$.ajax({
			url: "{{ url('app/user/action') }}",
			type: 'POST',
			dataType: 'json',
			data: formData,
			success: function(data) {
				$('.datagrid-panel').fadeIn();
				$('.form-panel').fadeOut();
				datagrid.reload();
			}
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