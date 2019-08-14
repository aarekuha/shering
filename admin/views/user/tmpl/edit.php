<?php
defined("_JEXEC") or die();

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');

JFactory::getDocument()->addScript(JUri::root(TRUE).'/administrator/components/com_shering/js/jquery.maskedinput.js');

$script = array();
$script[] = 'jQuery(function($){
               jQuery("#jform_tel").mask("(999) 999 99 99");
            });';
JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

?>

<form action="<?php echo JRoute::_('index.php?option=com_shering&layout=edit&id='.(int)$this->item->id); ?>"
      method="post" id="adminForm" name="adminForm" class="form-validate">
    <div class="span3">
        <?php echo $this->form->renderField('id'); ?>
        <?php echo $this->form->renderField('fio'); ?>
        <?php echo $this->form->renderField('registration_date'); ?>
    </div>
    <div class="span3">
        <?php echo $this->form->renderField('tel'); ?>
        <?php echo $this->form->renderField('password'); ?>
    </div>
    <div class="span3">
        <?php echo $this->form->renderField('smscounter'); ?>
        <?php echo $this->form->renderField('status'); ?>
    </div>

    <input type="hidden" name="task" value="user.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>

<div>
    <ul class="thumbnails" style="max-width: 800px;">
        <?php if (!empty($this->license1)) : ?>
            <li class="span6">
                <div class="thumbnail">
                    <img src="<?php echo $this->license1; ?>" alt="">
                    <h3>Водительское удостоверение</h3>
                    <p>Лицевая сторона</p>
                    <p><a class="btn btn-primary" href="<?php echo JRoute::_("index.php?option=com_shering&task=user.deletePhoto&" . JSession::getFormToken() . "=1&id=" . $this->item->id . "&prefix=1"); ?>">Удалить</a></p>
                </div>
            </li>
        <?php endif; ?>
        <?php if (!empty($this->license2)) : ?>
            <li class="span6">
                <div class="thumbnail">
                    <img src="<?php echo $this->license2; ?>" alt="">
                    <h3>Водительское удостоверение</h3>
                    <p>Оборотная сторона</p>
                    <p><a class="btn btn-primary" href="<?php echo JRoute::_("index.php?option=com_shering&task=user.deletePhoto&" . JSession::getFormToken() . "=1&id=" . $this->item->id . "&prefix=2"); ?>">Удалить</a></p>
                </div>
            </li>
        <?php endif; ?>
    </ul>
</div>

