(function ( $ ) {

	$.fn.validate = function(array, borderClass, errorClass) {

		var form = $(this);

		// Append error sesuai array
		var validate = (function() 
		{
			$(form).find('.' + errorClass).each(function () {
				$(this).remove();
			});

        	$(form).find('input[type=text]').each(function () {
        		$(this).removeClass(borderClass);
        		for (var key in array) {
					if(this.name == key) {
						$(this).addClass(borderClass);
						$(this).after('<span class="' + errorClass + '">' + array[key] + '</span>');	
					}
				}
			});

			$(form).find('input[type=password]').each(function () {
        		$(this).removeClass(borderClass);
        		for (var key in array) {
					if(this.name == key) {
						$(this).addClass(borderClass);
						$(this).after('<span class="' + errorClass + '">' + array[key] + '</span>');	
					}
				}
			});

			$(form).find('textarea').each(function () {
        		$(this).removeClass(borderClass);
				for (var key in array) {
					if(this.name == key) {
						$(this).addClass(borderClass);
						$(this).after('<span class="' + errorClass + '">' + array[key] + '</span>');	
					}
				}
			});

			$(form).find('select').each(function () {
        		$(this).removeClass(borderClass);
				for (var key in array) {
					if(this.name == key) {
						$(this).addClass(borderClass);
						$(this).after('<span class="' + errorClass + '">' + array[key] + '</span>');	
					}
				}
			});

			$(form).find('input[type=checkbox]').each(function () {
        		$(this).removeClass(borderClass);
				for (var key in array) {
					if(this.name == key && this.value == array[key]) {
						$(this).addClass(borderClass);
						$(this).after('<span class="' + errorClass + '">' + array[key] + '</span>');	
					}
				}
			});

			$(form).find('input[type=radio]').each(function () {
        		$(this).removeClass(borderClass);
				for (var key in array) {
					if(this.name == key && this.value == array[key]) {
						$(this).addClass(borderClass);
						$(this).after('<span class="' + errorClass + '">' + array[key] + '</span>');	
					}
				}
			});
		})();
	};

}( jQuery ));