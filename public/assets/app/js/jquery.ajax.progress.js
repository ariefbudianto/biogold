(function($) {
    var originalXhr = $.ajaxSettings.xhr;
    $.ajaxSetup({
        progress: $.noop,
        xhr: function() {
            var xhr = originalXhr(), that = this;
            xhr.upload.addEventListener("progress", function(evt) {
            	if (evt.lengthComputable) {
            		that.progress(evt);
				}
			}, false);
            return xhr;
        }
    });
})(jQuery);