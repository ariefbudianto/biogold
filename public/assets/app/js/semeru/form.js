(function ( $ ) {

	$.fn.formLoad = function(array) {

		var form = $(this);

		// Set element input sesuai array		
		var formLoad = (function() {
			$(form).find('input[type=text]').each(function () {
				for (var key in array) {
					if(this.name == key) {
						$(this).val(array[key]);
					}
				}
			});

			$(form).find('input[type=password]').each(function () {
				for (var key in array) {
					if(this.name == key) {
						$(this).val(array[key]);
					}
				}
			});

			$(form).find('textarea').each(function () {
				for (var key in array) {
					if(this.name == key) {
						$(this).val(array[key]);
					}
				}
			});

			$(form).find('select').each(function () {
				for (var key in array) {
					if (this.multiple) {
						if(this.name == key + '[]') {
							var select = this;
							$.each(array[key].split(','), function(i, e) {
								$(select).children('option').each(function() {
									if(this.value == e) {
										$(this).prop('selected', 'true');
									}
								});
							});
						}
					}else{
						if(this.name == key) {
							$(this).val(array[key]);
						}
					}
				}
			});

			$(form).find('input[type=checkbox]').each(function () {
				for (var key in array) {
					if(this.name == key && this.value == array[key]) {
						$(this).prop("checked", true);
					}
				}
			});

			$(form).find('input[type=radio]').each(function () {
				for (var key in array) {
					if(this.name == key && this.value == array[key]) {
						$(this).prop("checked", true);
					}
				}
			});
		})();
	};

}( jQuery ));