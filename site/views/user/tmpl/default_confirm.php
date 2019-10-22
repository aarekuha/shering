<?php
defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');

?>

<?php if ($this->incorrect_pin) : ?>
    <div class="alert alert-danger" role="alert">
        Неверно введен код подтверждения!
    </div>
<?php else : ?>
    <?php
        $script = array();
        $script[] = '$(document).ready(function(){
                       jQuery("#resendSms").delay(60 * 1000).fadeIn(0);
                    });';
        JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
    ?>
<?php endif; ?>

<form method="post">

    <div class="form-group">
        <label for="shering_pin">Код подтверждения:</label>
        <input type="text" class="form-control" id="shering_pin" name="shering_pin" aria-describedby="pinHelp" placeholder="Код подтверждения из СМС" required="required">
        <small id="pinHelp" class="form-text text-muted">
            <?php $input = JFactory::getApplication()->input; ?>
            На номер +7<?php echo substr($input->get("shering_tel"), -10); ?> отправлено СМС с кодом подтверждения.
            <?php if (!$this->incorrect_pin) : ?>
                <a href="javascript:document.location.reload(true);" id="resendSms" style="display: none;">Не пришло СМС?</a>
            <?php endif; ?>
        </small>
    </div>
    <a href="<?php echo JRoute::_("index.php?option=com_shering&view=user"); ?>" class="btn btn-primary">Назад</a>
    <button type="submit" class="btn btn-primary">Подтвердить</button>
    <input type="hidden" name="shering_tel" value="<?php echo $input->get("shering_tel"); ?>">
    <input type="hidden" name="task" value="user.checkConfirm">
    <?php echo $this->getRecaptchaText(); ?>
</form>


