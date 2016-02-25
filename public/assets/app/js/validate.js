(function ( $ ) {

	$.fn.validate = function(array, error_class) {

		var form = $(this);

		var validate = (function()
		{
        	$(form).find('input[type=text]').each(function () {
        		$(this).removeClass(error_class);
        		for (var key in array) {
					if(this.name == key) {
						$(this).addClass(error_class);
						$(this).attr("placeholder", array[key]);
					}
				}
			});

			$(form).find('input[type=password]').each(function () {
        		$(this).removeClass(error_class);
        		for (var key in array) {
					if(this.name == key) {
						$(this).addClass(error_class);
						$(this).attr("placeholder", array[key]);
					}
				}
			});

			$(form).find('textarea').each(function () {
        		$(this).removeClass(error_class);
				for (var key in array) {
					if(this.name == key) {
						$(this).addClass(error_class);
						$(this).attr("placeholder", array[key]);	
					}
				}
			});

			$(form).find('select').each(function () {
        		$(this).removeClass(error_class);
				for (var key in array) {
					if(this.name == key) {
						$(this).addClass(error_class);
					}
				}
			});

			$(form).find('input[type=checkbox]').each(function () {
        		$(this).removeClass(error_class);
				for (var key in array) {
					if(this.name == key && this.value == array[key]) {
						$(this).addClass(error_class);
					}
				}
			});

			$(form).find('input[type=radio]').each(function () {
        		$(this).removeClass(error_class);
				for (var key in array) {
					if(this.name == key && this.value == array[key]) {
						$(this).addClass(error_class);
					}
				}
			});
		})();
	};

}( jQuery ));