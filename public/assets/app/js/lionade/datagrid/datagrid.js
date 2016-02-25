(function ( $ ) {

	$.fn.datagrid = function(options) {

		var table 	= $(this);
		var data 	= [];
		var config 	= $.extend({
			url 				: '',
			primaryField		: '',
			sortBy				: '',
			orderBy				: 'DESC',
	        pagingElement 		: '',
	        optionPagingElement : '',
	        searchFromDateElement : '',
			searchToDateElement : '',
	        searchFieldElement	: '',
	        searchInputElement	: '',
	        pageInfoElement		: '',
	        rowNumber			: false, 
	        rowCheck			: false,
	        columns 			: [],
	        mergeCells			: [],
	       	activePageNumber	: 1,
	        itemsPerPage		: 5,
	        itemsPerPageOption 	: [5, 10, 25, 50, 100],
	        rowChecked 			: [],
	        queryParams 		: {}
	    }, options);

		$('body').prepend('<div class="alert_update" style="position: fixed; bottom: 15px; right: 15px; z-index: 1000; padding: 15px; background: #177bbb; color: #ffffff; font-weight: bold; border-radius: 5px; display:none;">Saved !</div>')
		
		// Create the table parts
		function BuildTableSection() {
			var tableString = "<thead></thead><tbody></tbody>";
			$(table).append(tableString);
		}

		// Merged cells
		function PrintMergeCells() {

			// Create a wrapper element for the merged cells
			var theadMergeCellsString = "<tr id='thead-merge-cells'></tr>";
			$(table).find('thead').append(theadMergeCellsString);

			// Show column number if it is enabled
			if (config.rowNumber == true) {
				var rowNumberString = "<th sortable='false' style='text-align: center; width: 20px;' rowspan='2'>No</th>";
				$(table).find('#thead-merge-cells').append(rowNumberString);
			}

			// Show column checkbox if it is enabled
			if (config.rowCheck == true) {
				var rowCheckString = "<th sortable='false' style='text-align: center; width: 20px;' rowspan='2'><input type='checkbox'></th>";
				$(table).find('#thead-merge-cells').append(rowCheckString);
				CheckAllRow();
			}

			// Check each merged cells by comparing an columns array and mergecells array
			config.columns.forEach(function(row_column, i) {

				var print_merge_thead = false;
				var align 		= '';
				var colspan 	= '';
				var title 		= '';

				// Check for each merged cells
				// If it is merged cells save property columns and show
				config.mergeCells.forEach(function(row_cell) {
					if (i == row_cell.index) {
						print_merge_thead = true;
						align 		= row_cell.align;
						colspan 	= row_cell.colspan;
						title 		= row_cell.title;
					}
				});

				// Check if the position of these cells exist between the merged cells
				// If yes then do not need to display anything
				if (!print_merge_thead) {
					config.mergeCells.forEach(function(row_cell) {
						if (i > row_cell.index && i < row_cell.index + row_cell.colspan) {
							print_merge_thead = null;
						}
					});
				}

				// Show the elements according to the conditions above
				var columnString = '';
				if (print_merge_thead) {
					columnString = "<th sortable='false' style='text-align: " + align + ";' colspan='" + colspan + "'>" + title + "</th>";
				} else if (print_merge_thead == false) {
					columnString = "<th title='" + row_column.field + "' sortable='" + row_column.sortable + "' style='text-align: " + row_column.align + "; width: " + row_column.width + "px;' rowspan='2'>" + row_column.title + "</th>"; 
				}

				$(table).find('#thead-merge-cells').append(columnString);
			});
		}

		// Regular cells
		function PrintNormalCells() {
			
			// Create a wrapper element for the regular cells
			var theadTitleString = "<tr id='thead-title'></tr>";
			$(table).find('thead').append(theadTitleString);

			// Show column number if it is enabled and mergecells array not defined
			if (config.rowNumber == true && config.mergeCells.length == 0) {
				var rowNumberString = "<th sortable='false' style='text-align: center; width: 20px;'>No</th>";
				$(table).find('#thead-title').append(rowNumberString);
			}
			
			// Show column checkbox if it is enabled and mergecells array not defined
			if (config.rowCheck == true && config.mergeCells.length == 0) {
				var rowCheckString = "<th sortable='false' style='text-align: center; width: 20px;'><input type='checkbox'></th>";
				$(table).find('#thead-title').append(rowCheckString);
				CheckAllRow();
			}
			
			// Show each column
			config.columns.forEach(function(row, i) {

				// Check if the position of these cells exist between the merged cells
				// If yes then show the cells but otherwise it does not need to display anything
				var print_normal_thead = false;
				if (config.mergeCells.length > 0) {
					config.mergeCells.forEach(function(row_cell) {
						if (i >= row_cell.index && i < row_cell.index + row_cell.colspan) {
							print_normal_thead = true;
						}
					});
				} else {
					print_normal_thead = true;
				}

				// Show the elements according to the conditions above
				var columnString;
				if (print_normal_thead) { 
					columnString = "<th title='" + row.field + "' sortable='" + row.sortable + "' style='text-align: " + row.align + "; width: " + row.width + "px;'>" + row.title + "</th>";
				}

				$(table).find('#thead-title').append(columnString);
			});
		}

		// Post data
		function AjaxRequest(activePageNumber, itemsPerPage, dataSearch) {
			var data;
			var postData = $.extend({
				limit 		: parseInt(activePageNumber) * itemsPerPage - itemsPerPage,
				offset 		: itemsPerPage, 
				sort 		: config.sortBy, 
				order 		: config.orderBy,
				dataSearch  : dataSearch
			}, config.queryParams);

			// Post data
			$.ajax({
				url 		: config.url,
				async 		: false,
				type 		: 'post',
				dataType 	: 'json',
				data 		: postData,
				success: function(responseJsonData) {
					data = responseJsonData;
				}
			});

			return data;
		}

		function datagridMessage(message) {
			var rowCount = config.columns.length + (GetUsedRow() + 1);
			var loading_temp = "<tr><td colspan='" + rowCount + "' style='text-align: center;'>" + message + "</td></tr>";
			$(table).find('tbody').html(loading_temp);
		}

		// Display data
		function DisplayData(activePageNumber, itemsPerPage, dataSearch) {

			// Loading status
			datagridMessage('Loading data...');

			// Ajax post
			data = AjaxRequest(activePageNumber, itemsPerPage, dataSearch);

			var pageNumber 	= (parseInt(activePageNumber) * itemsPerPage - itemsPerPage) + 1;
			var temp 		= "";
			var editable 	= [];

			if(data !== undefined){
				if (data.total >= 1) {
					for (var i = 0; i < data.rows.length; i++) {
						temp += "<tr>";

						// Show column number if it is enabled
						if (config.rowNumber) {
							temp += "<td style='text-align: center;'>" + pageNumber + "</td>";
						}

						// Show column checkbox if it is enabled
						if (config.rowCheck) {
							temp += "<td style='text-align: center;'><input value='" + data.rows[i][config.primaryField] + "' type='checkbox'></td>";
						}

						// check if the column is worth undefined then call the anonymous function
						config.columns.forEach(function(rowColumn) {
							if (data.rows[i][rowColumn.field] != undefined) {
								var field_value = (rowColumn.editable) ? '<form><input type="hidden" name="id" value="' + data.rows[i].id + '"><input class="editable" type="text" name="' + rowColumn.field + '" value="' + data.rows[i][rowColumn.field] + '"></form>' : data.rows[i][rowColumn.field];
								temp += "<td style='text-align: " + rowColumn.align + "; width: " + rowColumn.width + "px;'>" + field_value + "</td>";
							} else {
								temp += "<td style='text-align: " + rowColumn.align + "; width: " + rowColumn.width + "px;'>" + rowColumn.rowStyler(data.rows[i], i) + "</td>";
							}
						});

						temp += '</tr>';
						pageNumber++;
					}

					$(table).find('tbody').html(temp);

				} else {
					// Loading status
					datagridMessage('No records found...');
				}
			}

			// Paging data
			PagingData(activePageNumber, itemsPerPage);

			// Check uncheck row
			CheckRow();

			// Page info
			PageInfo(activePageNumber, itemsPerPage);	

			trigger_editable();

		}

		function trigger_editable()
		{
			$('.editable').focusout(function(event) {
				var formData = $(this).parent('form').serialize();
				$.post(editableOptions['post_url'], formData).done(function(data) { 
					$('.alert_update').fadeIn( 100 ).delay( 500 ).fadeOut( 100 );
				});
			});
		}

		// Display paging
		function PagingData(activePageNumber, itemsPerPage) {

			var temp = '';

			temp += '<li title="first"><a href="javascript:void(0);">First</a></li>';

			temp += '<li title="prev"><a href="javascript:void(0);">Prev</a></li>';

			if (activePageNumber == Math.ceil(data.total / itemsPerPage) && activePageNumber - 2 >= 1) {
				temp += '<li title="' + (activePageNumber - 2) + '"><a href="javascript:void(0);">' + (activePageNumber - 2) + '</a></li>';
			}

			if (activePageNumber - 1 >= 1) {
				temp += '<li title="' + (activePageNumber - 1) + '"><a href="javascript:void(0);">' + (activePageNumber - 1) + '</a></li>';
			}

			temp += '<li class="active" title="' + activePageNumber + '"><a href="javascript:void(0);">' + activePageNumber + '</a></li>';

			if (activePageNumber + 1 <= Math.ceil(data.total / itemsPerPage)) {
				temp += '<li title="' + (activePageNumber + 1) + '"><a href="javascript:void(0);">' + (activePageNumber + 1) + '</a></li>';
			}

			if (activePageNumber == 1 && Math.ceil(data.total / itemsPerPage) > 2) {
				temp += '<li title="' + (activePageNumber + 2) + '"><a href="javascript:void(0);">' + (activePageNumber + 2) + '</a></li>';
			}

			temp += '<li title="next"><a href="javascript:void(0);">Next</a></li>';

			temp += '<li title="last"><a href="javascript:void(0);">Last</a></li>';

			$(config.pagingElement).html(temp);
		
			if (Math.ceil(data.total / itemsPerPage) > 1) {
				$(config.pagingElement).children('li').each(function() {
					$(this).on('click', function() {

						if (this.title == "prev" && activePageNumber - 1 >= 1) {
							DisplayData(activePageNumber-1, itemsPerPage, SearchInput());
							config.activePageNumber--;
						
						} else if (this.title == "next" && activePageNumber + 1 <= Math.ceil(data.total / itemsPerPage)) {
							DisplayData(activePageNumber + 1, itemsPerPage, SearchInput());
							config.activePageNumber++;
						
						} else if (this.title == "first") {
							DisplayData(1, itemsPerPage, SearchInput());
							config.activePageNumber = 1;
						
						} else if (this.title == "last") {
							DisplayData(Math.ceil(data.total / itemsPerPage), itemsPerPage, SearchInput());
							config.activePageNumber = Math.ceil(data.total / itemsPerPage);
						
						} else if (parseInt(this.title) <= activePageNumber + 2 || parseInt(this.title) >= activePageNumber - 2) {
							DisplayData(parseInt(this.title), itemsPerPage, SearchInput());
							config.activePageNumber = this.title;
						}
					});
				});
			} else {
				$(config.pagingElement).children('li').each(function() {
					$(this).off();
				});
			}
		}

		// Option paging
		function OptionPaging() {
			// Option item perpage
			var tempOption = "";
			for (var i = 0; i < config.itemsPerPageOption.length; i++) {
				tempOption += "<option value='" + config.itemsPerPageOption[i] + "'>" + config.itemsPerPageOption[i] + "</option>";
			}

			$(config.optionPagingElement).html(tempOption);
			$(config.optionPagingElement).val(config.itemsPerPage);

			$(config.optionPagingElement).on('change', function() {
				config.itemsPerPage = $(config.optionPagingElement).children('option:selected').val();
				DisplayData(1, config.itemsPerPage, SearchInput());
			});
		}

		// Check used row
		function GetUsedRow() {
			var temp = -1;
			config.rowNumber == true ? temp += 1 : '';
			config.rowCheck == true ? temp += 1 : '';
			return temp;
		}

		// Chek uncheck row
		function CheckRow() {
			$(table).children('tbody').children('tr').each(function() {
				$(this).children().each(function(index, object) {
					if (index == GetUsedRow()) {
						$(this).children().each(function() {
							
							// Check Checkbox sesuai array
							for (var i = 0; i < config.rowChecked.length; i++) {
								if (config.rowChecked[i] == $(this).attr('value')) {
									$(this).prop("checked", true);
								}
							}

							$(this).on('click', function() {
								var temp, found = false;
								for (var i = 0; i < config.rowChecked.length; i++) {
									if (config.rowChecked[i] == this.value) {
										found = true;
										temp = i;
									}
								}

								if (!found) {
									config.rowChecked[config.rowChecked.length] = parseInt(this.value);
								} else {
									config.rowChecked.splice(temp, 1);
								}
								
								CheckTheadCheckbox();
							});
						});
					}
				});
			});

			CheckTheadCheckbox();
		}

		function CheckTheadCheckbox() {
			// Uncheck thead checkbox
			var selector 	= $(table).children('thead').find('input[type="checkbox"]');
			var arr 		= GetAllCheckbox();
			var boolCheck	= true;	

			for (var z = 0; z < arr.length; z++) {
				if (!$(arr[z]).prop("checked")) {
					boolCheck = false;
				}
			}

			if (boolCheck) {
				selector.prop('checked', true);
			} else {
				selector.prop('checked', false);
			}
		}

		function GetAllCheckbox() {
			var arr = [];
			$(table).children('tbody').children('tr').each(function() {
				$(this).children().each(function(index, object) {
					if (index == GetUsedRow()) {
						$(this).children().each(function() {
							arr[arr.length] = $(this);			
						});
					}
				});
			});

			return arr;
		}

		function CheckAllRow() {
			var selector = $(table).children('thead').find('input[type="checkbox"]');
			$(selector).on('click', function() {

				var arr = GetAllCheckbox();
				
				if ($(this).prop('checked')) {				
					for (var z = 0; z < arr.length; z++) {
						$(arr[z]).prop('checked', true);
	
						var temp, found = false;
						for (var i = 0; i < config.rowChecked.length; i++) {
							if (config.rowChecked[i] == $(arr[z]).attr('value')) {
								found = true;
								temp = i;
							}
						}

						if (!found) {
							config.rowChecked[config.rowChecked.length] = parseInt($(arr[z]).attr('value'));
						}
					}
				} else {			
					for (var z = 0; z < arr.length; z++) {
						$(arr[z]).prop('checked', false);

						var temp, found = false;
						for (var i = 0; i < config.rowChecked.length; i++) {
							if (config.rowChecked[i] == $(arr[z]).attr('value')) {
								found = true;
								temp = i;
							}
						}

						if (found) {
							config.rowChecked.splice(temp, 1);
						}
					}
				}
			});
		}

		// Search data
	    function Search() {
			config.columns.forEach(function(rowColumn) {
				if (rowColumn.search) {
					$(config.searchFieldElement).append('<option value="' + rowColumn.field+ '">' + rowColumn.title + '</option>');
				}
			});

			$(config.searchFromDateElement).on('change', function() {
	    		DisplayData(1, config.itemsPerPage, SearchInput());	 
	    		// console.log(config.searchFromDateElement);
	    	});

	    	$(config.searchToDateElement).on('change', function() {
	    		DisplayData(1, config.itemsPerPage, SearchInput());	 
	    	});

	    	$(config.searchInputElement).on('keyup', function() {
	    		DisplayData(1, config.itemsPerPage, SearchInput());	 
	    	});

	    	$(config.searchFieldElement).on('change', function() {
	    		DisplayData(1, config.itemsPerPage, SearchInput());
	    	});
	    }

	    // Search data
	    function SearchInput() {
	    	var from_date 	= $(config.searchFromDateElement).val();
	    	var to_date 	= $(config.searchToDateElement).val();
	    	var field 		= $(config.searchFieldElement).val();
    		var value 		= $(config.searchInputElement).val();
    		var temp 		= '';

    		if (value == '' && from_date == '' && to_date == '') {
    			temp = '';
    		} else {
    			temp =  { field : field, value : value, from_date : from_date, to_date : to_date};
    		}


    		return temp;
	    }

	    // Page info
	    function PageInfo(activePageNumber, itemsPerPage) {

	    	if (data.total >= 1) {
				var limit, offset;
				
				limit 		= ((activePageNumber * itemsPerPage) - itemsPerPage) + 1;
				if (activePageNumber == Math.ceil(data.total / itemsPerPage)) {
					offset = (activePageNumber * itemsPerPage) - ((activePageNumber * itemsPerPage) - data.total);
				} else {
					offset = (activePageNumber * itemsPerPage);
				}
				
				$(config.pageInfoElement).html('Showing ' + limit + ' - ' + offset + ' of ' + data.total + ' entries');
	    	} else {
	    		$(config.pageInfoElement).html('Showing ' + 0 + ' - ' + 0 + ' of ' + 0 + ' entries');
	    	}
	    }

	    function SortArrow() {
	    	$(table).children('thead').children().children().each(function(index, object) {
				if ($(object).attr('sortable') != 'false') {
			    	var arrow_up 	= $('<span></span>');
					$(arrow_up).css({
						'width' 		: '0px',
						'height' 		: '0px',
						'border'	 	: '4px solid transparent',
						'border-bottom'	: '5px solid #ccc',
						'position'		: 'absolute',
						'margin-left'	: '5px',
						'margin-top'	: '0px'
					});
					$(this).append(arrow_up);

					var arrow_down 	= $('<span></span>');
					$(arrow_down).css({
						'width' 		: '0px',
						'height' 		: '0px',
						'border'	 	: '4px solid transparent',
						'border-top' 	: '5px solid #ccc',
						'position'		: 'absolute',
						'margin-left'	: '5px',
						'margin-top'	: '11px'
					});
					$(this).append(arrow_down);
				}
			});
	    }

	    // Sort data
	    function SortData() {
	    	// Set sort data by primary field
	    	config.sortBy = config.primaryField;

	    	SortArrow();

			$(table).children('thead').children().children().each(function(index, object) {
				if ($(object).attr('sortable') != 'false') {

					$(this).css('cursor', 'pointer');
					
					$(this).on('click', function() {	
						$(table).children('thead').children().children().each(function(index, object) {
							$(this).children('span').remove();
						});

						SortArrow();

						var arrow = $('<span></span>');
						$(this).append(arrow);
						
						if ($(this).attr('data-sortby') == null || $(this).attr('data-sortby') == 'DESC') {
							$(this).attr('data-sortby', 'ASC');
							$(this).children('span').css({
								'width' 		: '0px',
								'height' 		: '0px',
								'border'	 	: '4px solid transparent',
								'border-bottom'	: '5px solid #333',
								'position'		: 'absolute',
								'margin-left'	: '5px',
								'margin-top'	: '3px'
							});
						} else {
							$(this).attr('data-sortby', 'DESC');
							$(this).children('span').css({
								'width' 		: '0px',
								'height' 		: '0px',
								'border'	 	: '4px solid transparent',
								'border-top' 	: '5px solid #333',
								'position'		: 'absolute',
								'margin-left'	: '5px',
								'margin-top'	: '7px'
							});
						}

						config.sortBy 	= this.title;
						config.orderBy 	= $(this).attr('data-sortby');

						DisplayData(config.activePageNumber, config.itemsPerPage, SearchInput());
					});	
				}
			});
	    }

	    this.reload = function() {
	    	DisplayData(config.activePageNumber, config.itemsPerPage, SearchInput());
	    }

		this.getChecked = function() {
			return config.rowChecked;
		}

		this.setChecked = function(arr) {
			for (var i = 0; i < arr.length; i++) {
				var temp = false;
				for (var z = 0; z < config.rowChecked.length; z++) {
					if (config.rowChecked[z] == arr[i]) {
						temp = true;
					}
				}

				if (!temp) {
					config.rowChecked[config.rowChecked.length] = arr[i];
				}
			}

			DisplayData(config.activePageNumber, config.itemsPerPage, SearchInput());
		}

		this.setUnchecked = function(arr) {
			for (var i = 0; i < arr.length; i++) {
				var index, temp = false;
				for (var z = 0; z < config.rowChecked.length; z++) {
					if (config.rowChecked[z] == arr[i]) {
						temp = true;
						index = z;
					}
				}

				if (temp) {
					config.rowChecked.splice(index, 1);
				}
			}

			DisplayData(config.activePageNumber, config.itemsPerPage, SearchInput());
		}
	
		this.getRowData = function(rowIndex) {
			return rowIndex == 'all' ? data.rows : data.rows[rowIndex];
		}

		function textMode(child, child_index, rowIndex, styler, onEdit, onSave) {
			if (child_index > GetUsedRow()) {
				var temp, field_name;
				config.columns.forEach(function(row_column, i) {
					if ((i + GetUsedRow() + 1) == child_index) {
						temp 		= row_column.editable;
						field_name 	= row_column.field;
					}
				});

				if (temp) {
					var temp 	= $(child).html();
					var object 	= styler(field_name, temp);
					
					// Check for last child element
					var lastElement;
					config.columns.forEach(function(row_column, i) {
						if (row_column.editable) {
							lastElement = i;
						}
					});

					if ($(child).attr('inline-edit') != 'active') {
						$(child).attr('inline-edit', 'active');
						$(child).html(object);
						if (lastElement + GetUsedRow() + 1 == child_index) {
							onEdit(child, object, rowIndex);
						}
					} else {
						$(child).attr('inline-edit', 'not-active');
						var element = $(child).children('form').serializeArray();
						$(child).html(element[0].value);
						data.rows[rowIndex][field_name] = element[0].value;
						if (lastElement + GetUsedRow() + 1 == child_index) {
							onSave();
						}
					}
				}
			}
		}

		function rowModifier(row, columnIndex, rowIndex, styler, onEdit, onSave) {
			$(row).children().each(function(child_index, child_object) {
				if (columnIndex == 'all') {
					textMode($(this), child_index, rowIndex, styler, onEdit, onSave);
				} else {
					if (child_index == (columnIndex + GetUsedRow() + 1)) {
						textMode($(this), child_index, rowIndex, styler, onEdit, onSave);
					}
				}
			});
		}

		this.editable = function(editableOptions) {

			var arrConfig 	= $.extend({
				rowIndex 	: 'all',
				columnIndex : 'all',
				styler 		: function(field_name, value) {
					return value;
				},
				onEdit 		: function(element, value, rowIndex) {
					$(element).find('input').focusout(function(event) {
						var formData = $(element).find('form').serialize();
						$.post(editableOptions['post_url'], formData).done(function(data) { 
							$('.alert_update').fadeIn( 100 ).delay( 500 ).fadeOut( 100 );
						});
					});
				},
				onSave 		: function() {
					console.log("Saved");
				}
		    }, editableOptions);

			$(table).children('tbody').children().each(function(index, object) {
				if (arrConfig.rowIndex == 'all') {
					rowModifier($(this), arrConfig.columnIndex, index, arrConfig.styler, arrConfig.onEdit, arrConfig.onSave);
				} else {
					if (index == arrConfig.rowIndex) {
						rowModifier($(this), arrConfig.columnIndex, index, arrConfig.styler, arrConfig.onEdit, arrConfig.onSave);
					}
				}
			});
		}

		this.queryParams = function(params) {
			config.queryParams = $.extend(config.queryParams, params);
		}

		// Main function
	    this.run = function() {

			// Create the table parts
			BuildTableSection();

			// View merged cells if the mergecells array is defined
			if (config.mergeCells.length > 0) {
				PrintMergeCells();
			}

			// View regular column header table
			PrintNormalCells();

			// Sort data
			SortData();

			// Display data
			DisplayData(config.activePageNumber, config.itemsPerPage, SearchInput());

			// Option Paging
			OptionPaging();

			// Search
			Search();
		}

	    return this;

	};

}( jQuery ));