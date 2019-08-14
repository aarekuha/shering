jQuery(document).ready(function(){

    jQuery('.upload-container').each(function(index, element)
    {
        jQuery(element).find('.file-input').focus(function () {
            jQuery('label').addClass('focus');
        })
            .focusout(function () {
                jQuery('label').removeClass('focus');
            });

        jQuery(element).on('drag dragstart dragend dragover dragenter dragleave drop', function () {
            return false;
        });

        jQuery(element).on('dragover dragenter', function () {
            jQuery(element).addClass('dragover');
        });

        jQuery(element).on('dragleave', function (e) {
            let dx = e.pageX - jQuery(element).offset().left;
            let dy = e.pageY - jQuery(element).offset().top;
            if ((dx < 0) || (dx > jQuery(element).width()) || (dy < 0) || (dy > jQuery(element).height())) {
                jQuery(element).removeClass('dragover');
            }
        });

        jQuery(element).on('drop', function (e) {
            jQuery(element).removeClass('dragover');
            let files = e.originalEvent.dataTransfer.files;
            sendFiles(files);
        });

        jQuery(element).find('.file-input').change(function () {
            let files = this.files;
            sendFiles(files);
        });

        function sendFiles(files) {
            let maxFileSize = 15242880;
            let Data = new FormData();

            hasError = false;

            jQuery(files).each(function (index, file) {
                if ((file.size <= maxFileSize) && ((file.type == 'image/png') || (file.type == 'image/jpeg'))) {
                    Data.append('images[]', file);
                    Data.append('prefix', jQuery(element).attr('prefix'));
                } else {
                    alert('Файл должен быть в формате PNG или JPEG и иметь размер не более 15Мб!');
                    hasError = true;
                }
            });

            if (hasError) {
                return;
            }

            tmpContainer = jQuery(element).html();
            jQuery(element).html('<div class=\"spinner-grow\" role=\"status\">' +
                '<span class=\"sr-only\">Загрузка изображения на сервер...</span>' +
                '</div>');

            jQuery.ajax({
                url: jQuery(element).attr('action'),
                type: jQuery(element).attr('method'),
                data: Data,
                contentType: false,
                processData: false,
                success: function (data) {
                    jQuery(element).html(tmpContainer);
                    if (data == 'ERROR') {
                        alert('Ошибка, при загрузке файла.');
                    } else {
                        var d = new Date();
                        jQuery(element).find("img").attr("src", "/images/cars/" + data + "?" + d.getTime());
                        itemIndex = jQuery(element).attr('suffix').slice(-1);
                        jQuery("#jform_images_image" + itemIndex).attr("value", data);
                        jQuery(element).find('.file-input').change(function () {
                            let files = this.files;
                            sendFiles(files);
                        });
                    }
                }
            });
        }
    });
});