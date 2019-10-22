<?php
defined("_JEXEC") or die();

JHtml::_('behavior.keepalive');

echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general'));
echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_SHERING_CARS_TAB_BASIC', true)); 
?>

<form action="<?php echo JRoute::_('index.php?option=com_shering&layout=edit&id='.(int)$this->item->id); ?>"
      method="post" id="adminForm" name="adminForm" class="form-validate">
    <div class="row-fluid">    
        <div class="row-fluid">
            <div class="span4">
                <?php echo $this->form->renderField('id'); ?>
                <?php echo $this->form->renderField('mark'); ?>
                <?php echo $this->form->renderField('model'); ?>
                <?php echo $this->form->renderField('class'); ?>
                <?php echo $this->form->renderField('year'); ?>
            </div>
            <div class="span4">
                <?php echo $this->form->renderField('engine_type'); ?>
                <?php echo $this->form->renderField('engine_size'); ?>
                <?php echo $this->form->renderField('transmission'); ?>
                <?php echo $this->form->renderField('color'); ?>
            </div>
            <div class="span4">
                <?php echo $this->form->renderField('interior'); ?>
                <?php echo $this->form->renderField('conditioner'); ?>
                <?php echo $this->form->renderField('car_number'); ?>
                <?php echo $this->form->renderField('cost'); ?>
                <?php echo $this->form->renderField('status'); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <?php echo $this->form->renderField('desc'); ?>
            </div>
        </div>    

        <div class="row-fluid">
            <?php echo $this->form->getControlGroup('images'); ?>
            <?php foreach ($this->form->getGroup('images') as $field) : ?>
            <div class="span3">
                <?php echo $field->getControlGroup(); ?>
            </div>
            <?php endforeach; ?>
        </div>
        <input type="hidden" name="" value="car.edit" />
        <input type="hidden" name="task" value="car.edit" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>

<?php echo JHtml::_('bootstrap.endTab'); ?>

<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('COM_SHERING_CARS_TAB_IMAGES', true)); ?>
    <?php echo $this->form->renderField('imageForm0'); ?>
    <?php echo $this->form->renderField('imageForm1'); ?>
    <?php echo $this->form->renderField('imageForm2'); ?>
    <?php echo $this->form->renderField('imageForm3'); ?>
    <?php echo $this->form->renderField('imageForm4'); ?>

<link href="https://unpkg.com/dropzone/dist/dropzone.css" rel="stylesheet" />
<link href="https://unpkg.com/croppie/croppie.css" rel="stylesheet" />
<script src="https://unpkg.com/dropzone"></script>
<script src="https://unpkg.com/croppie"></script>

<form action="<?php echo "index.php?option=com_shering&task=car.addImage&" . JSession::getFormToken() . "=1&suffix=0_0"; ?>"
      class="dropzone"
      style="width: 60%; height: 300px; position: relative; display: none;" 
      id="myDropzone"
      enctype="multipart/form-data"><input type="file" name="file" /></form>
  
<script>
    var imageWidth = 348;
    var imageHeight = 260;
    
    Dropzone.options.myDropzone = {
        dictDefaultMessage: "Перетащите файлы для добавления...",
        dictFileTooBig: "Файл слишком большой!",
        dictInvalidFileType: "Неправильный тип файла!",
        dictCancelUpload: "Отменить загрузку файла",
        dictRemoveFile: "Удалить",
        dictMaxFilesExceeded: "Максимальное количество файлов: 5",
        addRemoveLinks: true,
        maxFiles: 5,
//	url: '<?php echo "index.php?option=com_shering&task=car.addImage&" . JSession::getFormToken() . "=1&suffix=9_9"; ?>',
	transformFile: function(file, done) {

		var myDropZone = this;

		// Create the image editor overlay
		var editor = document.createElement('div');
		editor.style.position = 'absolute';
		editor.style.left = 0;
		editor.style.right = 0;
		editor.style.top = 0;
		editor.style.bottom = 0;
		editor.style.zIndex = 9999;
		editor.style.backgroundColor = '#EEE';
                document.getElementById('myDropzone').appendChild(editor);

		// Create the confirm button
		var confirm = document.createElement('button');
		confirm.style.position = 'absolute';
		confirm.style.left = '10px';
		confirm.style.top = '10px';
		confirm.style.zIndex = 9999;
		confirm.textContent = 'Обрезать';
		confirm.addEventListener('click', function() {
 
                    // Get the output file data from Croppie
                    croppie.result({
                        type:'blob',
                        size: {
                            width: imageWidth,
                            height: imageHeight
                        }
                    }).then(function(blob) {

                        // Update the image thumbnail with the new image data
                        myDropZone.createThumbnail(
                            blob,
                            myDropZone.options.thumbnailWidth,
                            myDropZone.options.thumbnailHeight,
                            myDropZone.options.thumbnailMethod,
                            false, 
                            function(dataURL) {
                                // Update the Dropzone file thumbnail
                                myDropZone.emit('thumbnail', file, dataURL);

                                // Return modified file to dropzone
                                console.log(blob);
                                done(blob);
                            }
                        );
                
                    });

                    // Remove the editor from view
                    editor.parentNode.removeChild(editor);

		});
		editor.appendChild(confirm);

		// Create the croppie editor
		var croppie = new Croppie(editor, {
                    viewport: {
                        width: imageWidth,
                        height: imageHeight
                    },
                    enableResize: false
		});

		// Load the image to Croppie
		croppie.bind({
                    url: URL.createObjectURL(file)
		});

	}
    };
</script>

<?php echo JHtml::_('bootstrap.endTab'); ?>

<?php echo JHtml::_('bootstrap.endTabSet'); ?>
