(function ( $ ) {

	$.fn.detailLoad = function(array) {

		var form = $(this);

		// Set element sesuai array		
		var detailLoad = (function() {
			$(form).find('div').each(function () {
				for (var key in array) {
					if(this.id == key) {
						$(this).html(array[key]);
					}
				}
			});
		})();
	};

}( jQuery ));