<?php
defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');

?>

<?php if ($this->userIsBlocked) : ?>
    <div class="alert alert-danger" role="alert">
        Ваш аккаунт заблокирован, обратитесь к администрации!
    </div>
<?php endif; ?>

<?php if ($this->incorrect_login) : ?>
    <div class="alert alert-danger" role="alert">
        Логин или пароль введены неверно! Если не удается войти, Вы можете <a href="<?php echo JRoute::_("index.php?option=com_shering&view=user&task=remember"); ?>">восстановить данные</a>.
    </div>
<?php endif; ?>

<?php if ($this->smsSended) : ?>
    <div class="alert alert-success" role="alert">
        На Ваш номер отправлен новый пароль. Не забудьте сменить его после входа в систему.
    </div>
<?php endif; ?>

<form action="<?php echo JRoute::_("index.php?option=com_shering&view=user"); ?>" method="post" id="form">
    <div class="form-group">
        <label for="tel">Телефон:</label>
        <input type="tel" class="form-control" id="shering_tel" name="shering_tel" aria-describedby="telHelp" placeholder="Номер телефона" required="required">
        <small id="telHelp" class="form-text text-muted">Номер телефона в формате 9001234567.</small>
    </div>
    <div class="form-group">
        <label for="password">Пароль:</label>
        <input type="password" class="form-control" id="shering_password" name="shering_password" placeholder="Пароль" required="required" value="">
    </div>
    <div class="form-group">
        <a href="<?php echo JRoute::_("index.php?option=com_shering&view=user&task=remember"); ?>">Регистрация (займет меньше одиной минуты) / Восстановление пароля</a>
    </div>
    <button type="submit" class="btn btn-primary">Войти</button>
    <input type="hidden" name="task" value="login">
    <?php echo $this->getRecaptchaText(); ?>
</form>


