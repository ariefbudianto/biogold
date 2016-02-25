<!DOCTYPE html>
<html>
	<head>
		<title>Lionade</title>
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap-theme.min.css">
		<script type="text/javascript" src="assets/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="assets/lionade/datagrid.js"></script>
		<script type="text/javascript">

			var datagrid;
			$(document).ready(function() {
				datagrid = $("#datagrid").datagrid({
					url						: 'serverside/albums.php', 
					primaryField			: 'id', 
					rowNumber				: true, 
					rowCheck 				: true, 
					rowChecked 				: [10904, 10903, 10902],
					searchInputElement 		: '.search-input',
					searchFieldElement 		: '.search-option',
					pagingElement 			: '.pagination-main',
					optionPagingElement 	: '.option',
					pageInfoElement 		: '.info',
					mergeCells				: [
						{index: 3, title: 'Action', align: 'center', colspan: 2}
					],
					columns					: [
			        	{field: 'artists_name', title: 'Artist Name', editable: true, sortable: true, width: 180, align: 'center', search: true},
			        	{field: 'album_name', title: 'Album Name', editable: true, sortable: true, width: 180, align: 'center', search: true},
			        	{field: 'year', title: 'Year', editable: true, sortable: true, width: 80, align: 'center', search: true},
			        	{field: 'edit', title: 'Edit', sortable: false, width: 80, align: 'center', search: false, 
			        		rowStyler: function(rowData, rowIndex) {
			        			return edit(rowIndex);
			        		}
			        	},
			        	{field: 'show', title: 'Detail Data', sortable: false, width: 80, align: 'center', search: false, 
			        		rowStyler: function(rowData, rowIndex) {
			        			return show(rowIndex);
			        		}
			        	}
			        ],
			        rowDetail				: {
			        	formatter : function(rowData, rowIndex) {
			        		return row_detail(rowData, rowIndex);
			        	},
			        	onExpandRow : function(rowData, rowIndex) {
			        		var datagrid_detail = $("#datagrid-" + rowIndex).datagrid({
								url						: 'serverside/songs.php',
								queryParams 			: { album_id : rowData.id },
								primaryField			: 'id',
								rowNumber				: true,
								itemsPerPage			: 2,
								pagingElement 			: '#pagination-' + rowIndex,
								optionPagingElement 	: '#option-' + rowIndex,
								pageInfoElement 		: '#info-' + rowIndex,
								columns					: [
						        	{field: 'song_title', title: 'Song Title', editable: true, sortable: true, width: 250, align: 'center', search: true}
						        ]
							});

							datagrid_detail.run();
			        	}
			        }
				});

				datagrid.run();

				$('#get').on('click', function() {
					alert(datagrid.getChecked());
				});

				$('#set').on('click', function() {
					datagrid.setChecked([5, 6, 7]);
				});

				$('#unset').on('click', function() {
					datagrid.setUnchecked([5, 6, 7]);
				});
			});

			function edit(rowIndex) {
				var button = '<button class="btn btn-primary" onclick="editable(' + rowIndex + ')" style="margin-bottom: 10px;">Edit</button>';
				return button;
			}

			function show(rowIndex) {
				var button = '<button class="btn btn-primary" onclick="data(' + rowIndex + ')" style="margin-bottom: 10px;">Show</button>';
				return button;
			}

			function data(rowIndex) {
				return alert(datagrid.getRowData(rowIndex).artists_name + '-' + datagrid.getRowData(rowIndex).album_name + '-' + datagrid.getRowData(rowIndex).year);
			}

			function editable(rowIndex) {
				datagrid.editable({
					rowIndex 	: rowIndex,
					columnIndex : 'all',
					styler 		: function(field_name, value) {
						return "<input type='text' class='form-control' name='" + field_name + "' value='" + value + "'>";
					},
					onEdit 		: function() {
						console.log("Edited");
					},
					onSave 		: function() {
						console.log(datagrid.getRowData(rowIndex));
					}
				});
			}

			function row_detail(rowData, rowIndex) {
				return "<table class='table table-bordered table-striped' id='datagrid-" + rowIndex + "'></table>" +
					   "<div class='col-md-1'>" +
					   		"<select class='form-control' id='option-" + rowIndex + "'></select>" +
					   "</div>" +
					   "<div class='col-md-5'>" +
					   		"<ul class='pagination' id='pagination-" + rowIndex + "' style='margin-top: 0px;'></ul>" +
					   "</div>" +
					   "<div class='col-md-6 text-right'>" +
					   		"<span id='info-" + rowIndex + "'></span>" +
					   "</div>";
			}

		</script>
	</head>
	<body>
		<div class="container">
			<div class="col-md-12" style="margin-top: 50px;">
				<div class="col-md-7">
					<button class="btn btn-primary" id="get" style="margin-bottom: 10px;">Get Checked Row</button>
					<button class="btn btn-default" id="set" style="margin-bottom: 10px;">Set Checked Row</button>
					<button class="btn btn-danger" id="unset" style="margin-bottom: 10px;">Unset Checked Row</button>
				</div>
				<div class="col-md-5 text-right form-inline">
					<select class="form-control search-option"></select>
					<input type="text" class="form-control search-input" placeholder="Search...">
				</div>
				<table class="table table-bordered table-striped" id="datagrid"></table>
				<div class="col-md-1">
					<select class="form-control option"></select>
				</div>
				<div class="col-md-5">
					<ul class="pagination pagination-main" style="margin-top: 0px;"></ul>
				</div>
				<div class="col-md-6 text-right">
					<span class="info"></span>
				</div>
			</div>
		</div>
	</body>
</html>