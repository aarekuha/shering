$(document).ready(function(){
    var tmpContainer = new Object();
    var dropZone = $('#upload-container');

    $('#file-input').focus(function() {
        $('label').addClass('focus');
    })
        .focusout(function() {
            $('label').removeClass('focus');
        });

    dropZone.on('drag dragstart dragend dragover dragenter dragleave drop', function(){
        return false;
    });

    dropZone.on('dragover dragenter', function() {
        dropZone.addClass('dragover');
    });

    dropZone.on('dragleave', function(e) {
        let dx = e.pageX - dropZone.offset().left;
        let dy = e.pageY - dropZone.offset().top;
        if ((dx < 0) || (dx > dropZone.width()) || (dy < 0) || (dy > dropZone.height())) {
            dropZone.removeClass('dragover');
        }
    });

    dropZone.on('drop', function(e) {
        dropZone.removeClass('dragover');
        let files = e.originalEvent.dataTransfer.files;
        sendFiles(files);
    });

    $('#file-input').change(function() {
        let files = this.files;
        sendFiles(files);
    });

    function sendFiles(files) {
        let maxFileSize = 15242880;
        let Data = new FormData();

        if (files.length > 1) {
            alert('Возможна загрузка только одного файла.');
            return;
        }

        hasError = false;

        $(files).each(function(index, file) {
            if ((file.size <= maxFileSize) && ((file.type == 'image/png') || (file.type == 'image/jpeg'))) {
                Data.append('images[]', file);
                Data.append('prefix', dropZone.attr('prefix'));
            } else {
                alert('Файл должен быть в формате PNG или JPEG и иметь размер не более 15Мб!');
                hasError = true;
            }
        });

        if (hasError) {
            return;
        }

        tmpContainer = dropZone.html();
        dropZone.html('<div class=\"spinner-grow\" role=\"status\">' +
            '<span class=\"sr-only\">Загрузка изображения на сервер...</span>' +
            '</div>');

        $.ajax({
            url: dropZone.attr('action'),
            type: dropZone.attr('method'),
            data: Data,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data == 'ERROR') {
                    alert ('Ошибка, при загрузке файла. Сообщите администрации.');
                } else {
                    dropZone.html(tmpContainer);
                    $('#file-input').change(function() {
                        let files = this.files;
                        sendFiles(files);
                    });
                    var prefix = dropZone.attr('prefix');
                    if ((prefix == 1) && (!license2.length)) {
                        dropZone.attr('prefix', '2');
                        $('#appendLicenseSpan').html('(Оборотная сторона)');
                        setLicense(1, data);
                    }

                    if ((prefix == 1) && (license2.length)) {
                        dropZone.parent().hide();
                        setLicense(1, data);
                    }

                    if (prefix == 2) {
                        dropZone.parent().hide();
                        setLicense(2, data);
                    }
                }
            }
        });
    }

    function setLicense(_prefix, filename) {
        license = $('#license' + _prefix);
        license.attr('src', filename);

        license.parent().parent().show();
    }

    if (license1.length) {
        setLicense(1, license1);
    } else {
        dropZone.attr('prefix', 1);
        $('#appendLicenseSpan').html('(Лицевая сторона)');
    }

    if (license2.length) {
        setLicense(2, license2);
    } else if (license1.length) {
        dropZone.attr('prefix', 2);
        $('#appendLicenseSpan').html('(Оборотная сторона)');
    }
})