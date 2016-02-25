(function ( $ ) {

    $.fn.uploader = function(options) {

        var settings = $.extend({
            filePreview             : '',
            maxTotalFiles           : 1,
            currentTotalFile        : 0,
            currentTotalFileSize    : 0,
            inputCount              : 0,
            arrDeletedFiles         : [],
            arrImageExtension       : ["png", "jpeg", "jpg", "ico"],
            arrFileType             : [ 
                                        "image/png",
                                        "image/jpeg", 
                                        "application/pdf", 
                                        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                                        "image/vnd.microsoft.icon"
                                      ],
            wpFile                  : $(this)
        }, options );

        ! function onLoad() {

            var multiple = settings.maxTotalFiles > 1 ? 'multiple' : '';
            
            if (settings.inputCount == 0) {
                $(settings.wpFile).parent().append("<input type='hidden' id='deleted-files' name='deleted_files'>");
                $(settings.wpFile).append("<input type='file' id='input-" + settings.inputCount + "' name='files[]' " + multiple + ">");
                settings.inputCount++;
            }

            $(settings.wpFile).children("input").each(function() {

                var input = this;

                $(this).on("change", function() {
                    for (var i = 0; i < input.files.length; i++) {
                        var arrData = {
                            'type'                  : input.files[i].type,
                            'currentTotalFile'      : settings.currentTotalFile,
                            'maxTotalFile'          : settings.maxTotalFiles,
                            'inputFileSize'         : input.files[i].size,
                            'currentTotalFileSize'  : settings.currentTotalFileSize,
                            'arrFileType'           : settings.arrFileType,
                        };

                        var validateData = validate(arrData);

                        if (validateData.success) {
                            $(settings.wpFile).children("input").hide();
                            
                            var reader = new FileReader();

                            reader.onload = function (fileReader, i) {
                                return function (e) {
                                    var fileName = cutter(fileReader.name);
                                    var fileType = fileReader.type;
                                    var addElement = addTemplate(e.target.result, settings.filePreview, settings.inputCount, fileName, fileType);
                                    var multiple = settings.maxTotalFiles > 1 ? 'multiple' : '';
                                    
                                    $(settings.wpFile).append("<input type='file' id='input-" + settings.inputCount + "' name='files[]' " + multiple + ">");
                                    
                                    settings.inputCount++;
                                    settings.currentTotalFile++;

                                    var reCall = onLoad();
                                    var remover = removerFile();
                                };
                            
                            }(input.files[i], i);
                            reader.readAsDataURL(input.files[i]);
                        } else {
                            alert(validateData.message);
                        }
                    }
                });
            });
        }();

        function removerFile() {
            var arrDeletedFiles = settings.arrDeletedFiles;
            $('.thumbnail-cancel').each(function() {
                $(this).on('click', function() {
                    $(this).parent().parent().parent().fadeOut();
                    $('#input-' + this.id).remove();
                    var fileName = $(this).parent().parent().find('img').attr('alt');
                    if ($.inArray(fileName, arrDeletedFiles) == -1) {
                        arrDeletedFiles[arrDeletedFiles.length] = fileName;
                    }

                    $('#deleted-files').val(JSON.stringify(arrDeletedFiles));
                    settings.currentTotalFile--;
                });
            });
        }

        function addTemplate(src, filePreviewElement, inputCount, fileName, fileType) {
            var template = "<div class='wp-thumbnail'>"+
                                "<div class='thumbnail'>"+
                                    "<a href='#'><img class='image-" + inputCount + "' src='' alt=''></a>"+
                                    "<div class='caption'>"+
                                        "<p class='text-ellipsis m-b-none wp-title'><div class='thumbnail-title'>" + fileName + "</div><div class='thumbnail-cancel' id='" + (inputCount-1) + "'>Remove</div></p>"+
                                    "</div>"+
                                "</div>"+
                            "</div>";

            $(filePreviewElement).append(template);
            $('.wp-thumbnail').each(function() {
                $(this).css({
                    '-webkit-animation' : 'showSlowlyElement 700ms',
                    'animation'         : 'showSlowlyElement 700ms'
                })
            });

            if (fileType == "application/pdf") {
                src = retrieveURL() + "images/pdf.png";
            } else if (fileType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                src = retrieveURL() + "images/doc.png";
            }

            $('.image-' + inputCount).attr('src', src);
        }

        function retrieveURL() {
            var url;
            var scriptName = 'uploader';
            var scripts = document.getElementsByTagName('script');

            if (scripts && scripts.length > 0) {
                for (var i in scripts) {
                    if (scripts[i].src && scripts[i].src.match(new RegExp(scriptName+'\\.js$'))) {
                        url = scripts[i].src.replace(new RegExp('(.*)'+scriptName+'\\.js$'), '$1');
                    }
                }
            }

            return url;
        }

        function cutter(fileName) {
            if (fileName.length > 10) {
                fileName = fileName.substring(0, 8) + '...';
            }
            return fileName;
        }

        function fileTypeChecker(arrFileType, type) {
            var temp = false;
            for (var i = 0; i < arrFileType.length; i++) {
                if (arrFileType[i] == type) {
                    temp = true;
                }
            }
            return temp;
        }

        function maxTotalFileChecker(currentTotalFile, maxTotalFile) {
            return currentTotalFile < maxTotalFile ? true : false;
        }

        function maxTotalFileSizeChecker(inputFileSize, currentTotalFileSize) {
            var returnTemp = false;
            if (inputFileSize <= 8388608 && currentTotalFileSize <= 7388608) {
                returnTemp = true;
            }
            return returnTemp;
        }

        function validate(arrData) {
            var validateStatus = true;
            var message;
            
            if (!fileTypeChecker(arrData['arrFileType'], arrData['type'])) {
                message = 'Incorrect file type';
                validateStatus = false;
            }

            if (!maxTotalFileChecker(arrData['currentTotalFile'], arrData['maxTotalFile'])) {
                message = 'Out of maksimum total file allowed, please remove one of files first';
                validateStatus = false;
            }

            if (!maxTotalFileSizeChecker(arrData['inputFileSize'], arrData['currentTotalFileSize'])) {
                message = '7 Mb maximum total file size allowed';
                validateStatus = false;
            }            

            return { 'success' : validateStatus, 'message' : message };
        }

        function imageExtensionChecker(fileName) {
            var arrFileName = fileName.split(".");
            var extension = arrFileName[arrFileName.length-1];
            var found = false;

            for (var i = 0; i < settings.arrImageExtension.length; i++) {
                if (settings.arrImageExtension[i] == arrFileName[arrFileName.length-1]) {
                    found = true;
                }
            }

            return {'found' : found, 'extension' : extension};
        }

        this.setData = function(directory, arrImages) {
            $(arrImages.split(',')).each(function(key, fileName) {
                var newFileName = cutter(fileName);
                var extensionChecker = imageExtensionChecker(fileName);
                var fileExtension = extensionChecker['extension'] == 'docx' || extensionChecker['extension'] == 'doc' ? "images/doc.png" : "images/pdf.png";
                var newDirectory = extensionChecker['found'] ? directory + fileName : retrieveURL() + fileExtension;
                var template = "<div class='wp-thumbnail'>"+
                                    "<div class='thumbnail'>"+
                                        "<a href='#'><img src='" + newDirectory + "' alt='" + fileName + "'></a>"+
                                        "<div class='caption'>"+
                                            "<p class='text-ellipsis m-b-none wp-title'><div class='thumbnail-title'>" + newFileName + "</div><div class='thumbnail-cancel'>Remove</div></p>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>";

                $(settings.filePreview).append(template);
                var remover = removerFile();
                settings.currentTotalFile++;
            });
        }

        return this;
    };

}( jQuery ));