<?php
defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');

?>

<form method="post" id="form">
    <div class="form-group">
        <label for="tel">Телефон:</label>
        <input type="tel" class="form-control" id="shering_tel" name="shering_tel" aria-describedby="telHelp" placeholder="Номер телефона" required="required">
        <small id="telHelp" class="form-text text-muted">Номер телефона в формате 9001234567.</small>
    </div>
    <button type="submit" class="btn btn-primary">Отправить СМС</button>
    <input type="hidden" name="task" value="user.confirm">
    <?php echo $this->getRecaptchaText(); ?>
</form>