/*!
 * Lionade JavaScript Library v1.0
 * http://lionadejs.com/
 *
 * Copyright 2015, Muhammad Rizki Akbar
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://lionadejs.com/license
 */

(function ( $ ) {

	$.fn.uploader = function(options) {

		var uploader 	= $(this);
		var config 		= $.extend({
			scan_url			: '',
			upload_url			: '',
			selected_image  	: '',
			image_directory		: ''
	    }, options);

	    function construct() {
	    	var element =   '<div class="file">' +
								'<div class="toolbar-menu">' +
									'<ul>' +
										'<li title="select-file" class="active">Media Library</li>' +
										'<li title="upload-file">Upload Files</li>' +
									'</ul>' +
								'</div>' +
								'<div class="content">' +
									'<div class="wp-title">' +
										'<span id="title">Insert Media</span>' +
										'<span id="close">x</span>' + 
									'</div>' +
									'<div class="wp-images"></div>' +
									'<div class="wp-uploader hde">' +
										'<div class="wp-loading">' +
											'<div class="fill"></div>' +
										'</div>' +
										'<div class="file-upload">' +
										    '<span>Select File</span>' +
										    '<input type="file" class="upload">' +
										'</div>' +
											'<p>Maximum upload file size: 128 MB.</p>' +
										'<div class="wp-button">' +
											'<button>Select File</button>' +
										'</div>' +
									'</div>' +
								'</div>' +
							'</div>';

			$(uploader).html(element);

			$(uploader).find('.wp-button').children('button').on('click', function() {
				$(uploader).fadeOut();
			});

			$(uploader).find('.wp-title').children('#close').on('click', function() {
				$(uploader).fadeOut();
			});
	    }

		function switch_menu() {
			$(uploader).find('.toolbar-menu').children('ul').children('li').each(function() {
				$(this).on('click', function() {
					$(uploader).find('.toolbar-menu').children('ul').children('li').each(function() {
						$(this).removeClass('active');
					});

					if ($(this).attr('title') == 'upload-file') {
						$(this).addClass('active');
						$(uploader).find('.wp-images').fadeOut(function() {
							$(uploader).find('.wp-uploader').fadeIn();
						});
					} else {
						$(this).addClass('active');
						$(uploader).find('.wp-uploader').fadeOut(function() {
							$(uploader).find('.wp-images').fadeIn();
						});
					}
				});
			});
		}

		function scan_file() {
			$.post(config.scan_url).done(function(data) {
				$(uploader).find('.wp-images').html('');
				for (var i = 0; i < data.length; i++) {
					var image = $('<img title="' + data[i] + '" src="' + config.image_directory + data[i] + '">');
					$(uploader).find('.wp-images').append(image);

					$(image).on('click', function() {
						$(uploader).find('img').each(function() {
							$(this).removeClass('active');
						});
						$(this).addClass('active');
						config.selected_image = this.title;
					});
				}

				set_active_image();
			});
		}

		function upload() {
			$(uploader).find('input[type="file"]').on('change', function() {
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

			    var data = new FormData();
				$(uploader).find("input[type=file]").each(function() {
					data.append("files[]", this.files[0]);
				});

				$(uploader).find('.wp-loading').fadeIn(function() {
					$(uploader).find('.file-upload').fadeOut(function() {
						$(uploader).find('.wp-uploader').children('p').fadeOut(function() {
							$.ajax({
								url: config.upload_url,
								type: "POST",
								data: data,
								cache: false,
								dataType: "json",
								processData: false,
								contentType: false,
								complete: function(data) {
									var data = JSON.parse(data.responseText);
									if (data.message == 'success') {
										config.selected_image = data.image;
										$(uploader).find('.wp-loading').fadeOut();
										$(uploader).find('.file-upload').fadeIn();
										$(uploader).find('.wp-uploader').children('p').fadeIn();
										$(uploader).find('.toolbar-menu').children('ul').children('li').each(function() {
											if ($(this).attr('title') == 'upload-file') {
												$(this).removeClass('active');
											} else {
												$(this).addClass('active');
											}

											$(uploader).find('.wp-uploader').fadeOut(function() {
												$(uploader).find('.wp-images').fadeIn();
												scan_file();
											});
										});
										var input = $(uploader).find('input[type="file"]');
										input.replaceWith(input.val('').clone(true));
										console.log("Completed.");
									} else {
										alert(data.message);
									}
								},
								progress: function(evt) {
									if (evt.lengthComputable) {
										$(uploader).find(".fill").css("width",  parseInt( (evt.loaded / evt.total * 100), 10) + "%");
										console.log("Uploaded " + parseInt( (evt.loaded / evt.total * 100), 10) + "%");
									} else {
										console.log("Length not computable.");
									}
								}
							});
						});	
					});
				});
			});
		}

		function set_active_image() {
			$(uploader).find('.wp-images').children('img').each(function() {
				if ($(this).attr('title') == config.selected_image) {
					$(this).addClass('active');
				}
			});
		}

		this.show = function() {
			$(uploader).fadeIn();
		}

		this.on_select_image = function(modifier) {
			$(uploader).find('.wp-button').children('button').on('click', function() {
				modifier(config.selected_image);
			});
		}

		// Main function
	    this.run = function() {
	    	construct();

	    	switch_menu();

	    	scan_file();

	    	upload();
		}

	    return this;

	};

}( jQuery ));