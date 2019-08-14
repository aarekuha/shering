<?php
defined("_JEXEC") or die();

JHtml::_('behavior.keepalive');
?>

<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_SHERING_CARS_TAB_BASIC', true)); ?>

<form action="<?php echo JRoute::_('index.php?option=com_shering&layout=edit&id='.(int)$this->item->id); ?>"
      method="post" id="adminForm" name="adminForm" class="form-validate">
        <?php // echo $this->form->renderFieldset('basic'); ?>
        <div class="span3">
            <?php echo $this->form->renderField('id'); ?>
            <?php echo $this->form->renderField('mark'); ?>
            <?php echo $this->form->renderField('model'); ?>
            <?php echo $this->form->renderField('class'); ?>
            <?php echo $this->form->renderField('year'); ?>
        </div>
        <div class="span3">
            <?php echo $this->form->renderField('engine_type'); ?>
            <?php echo $this->form->renderField('engine_size'); ?>
            <?php echo $this->form->renderField('transmission'); ?>
        </div>
        <div class="span3">
            <?php echo $this->form->renderField('interior'); ?>
            <?php echo $this->form->renderField('conditioner'); ?>
            <?php echo $this->form->renderField('car_number'); ?>
            <?php echo $this->form->renderField('cost'); ?>
            <?php echo $this->form->renderField('status'); ?>
        </div>

    <?php echo $this->form->getControlGroup('images'); ?>
    <?php foreach ($this->form->getGroup('images') as $field) : ?>
        <?php echo $field->getControlGroup(); ?>
    <?php endforeach; ?>
    <input type="hidden" name="" value="car.edit" />
    <input type="hidden" name="task" value="car.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>

<?php echo JHtml::_('bootstrap.endTab'); ?>

<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('COM_SHERING_CARS_TAB_IMAGES', true)); ?>
    <?php echo $this->form->renderField('imageForm0'); ?>
    <?php echo $this->form->renderField('imageForm1'); ?>
    <?php echo $this->form->renderField('imageForm2'); ?>
    <?php echo $this->form->renderField('imageForm3'); ?>
    <?php echo $this->form->renderField('imageForm4'); ?>
<?php echo JHtml::_('bootstrap.endTab'); ?>

<?php echo JHtml::_('bootstrap.endTabSet'); ?>
