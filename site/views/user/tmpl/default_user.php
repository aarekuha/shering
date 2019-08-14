<?php
defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');

$script = array();
$script[] = "var license1 = '" . ($this->license1) . "';
             var license2 = '" . ($this->license2) . "';";
JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
JFactory::getDocument()->addScript(JUri::base() . "components/com_shering/js/user.js");

JFactory::getDocument()->addStyleSheet(JUri::base() . "components/com_shering/css/user.css");

?>
<div class="accordion" id="accordionExample">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    <i class="fa fa-user-tie"> </i> Пользователь
                </button>
            </h2>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <form action="<?php JRoute::_("index.php"); ?>" method="post">
                    <div class="form-group" style="margin-bottom: 30px;">
                        Номер телефона: <b>+7 <?php echo $this->item->tel; ?></b>
                        <small class="form-text text-muted">Для изменения номера телефона обратитесь к администрации.</small>
                    </div>
                    <div class="form-group" style="margin-bottom: 30px;">
                        <label for="fio">Фамилия Имя Отчество</label>
                        <input type="text" class="form-control" id="fio" name="fio" aria-describedby="fioHelp" placeholder="Фамилия Имя Отчество (полностью)" value="<?php echo $this->item->fio; ?>">
                        <small id="fioHelp" class="form-text text-muted">Фамилия Имя Отчество (указать данные полностью, при изменении статус проверки будет изменен на "Не проверен")</small>
                    </div>
                    <div class="form-group" style="margin-bottom: 30px;">
                        <label for="password">Пароль</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Пароль" aria-describedby="passwordHelp" value="">
                        <small id="passwordHelp" class="form-text text-muted">Длина пароля должна быть от 4 до 15 символов</small>
                    </div>
                    <div class="row" style="margin-bottom: 30px;">
                        <div class="col-sm">
                            Дата регистрации: <b><?php echo (new DateTime($this->item->registration_date))->format('d.m.Y'); ?> г.</b>
                        </div>
                        <div class="col-sm">
                            Статус проверки: <b>
                                <?php
                                switch ($this->item->status) {
                                    case 1 : echo "<span style='color: darkgreen;'>Проверен</span>"; break;
                                    case 2 : echo "<span style='color: darkred;'>Заблокирован</span>"; break;
                                    default : echo "<span style='color: grey;'>Не проверен</span>";
                                }
                                ?>
                            </b>
                            <?php if ($this->item->status == 2) : ?>
                                <small class="form-text text-muted">Обратитесь к администрации.</small>
                            <?php endif; ?>
                        </div>
                        <div class="col-sm">
                            Вам отправлено <b><?php echo $this->item->smscounter; ?> СМС</b>.
                            <small class="form-text text-muted">После отправки трех СМС с предложениями. Ваши заявки становятся неактивными.</small>
                        </div>
                    </div>

                    <script>
                        function enableSaveButton() {
                            saveButton = document.getElementById("save_button");
                            cbResetStatus = document.getElementById("cbResetStatus");
                            cbAppend = document.getElementById("cbAppend");

                            saveButton.disabled = !((cbAppend.checked) && (cbResetStatus.checked));
                        }
                    </script>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="cbAppend" onclick="javascript:enableSaveButton();">
                        <label for="cbAppend" class="form-check-label" ><i>Даю свое согласие на сбор и обработку персональных данных.</i></label>
                    </div>
                    <div class="form-group form-check" style="margin-bottom: 30px;">
                        <input type="checkbox" class="form-check-input" id="cbResetStatus" onclick="javascript:enableSaveButton();">
                        <label for="cbResetStatus" class="form-check-label"><i>При изменении поля ФИО статус пользователя будет изменен на "Не проверен". Заявки станут неактивны.</i>></label>
                    </div>
                    <a href="javascript:document.getElementById('logoffForm').submit();" class="btn btn-primary"><i class="fa fa-sign-out-alt"> </i> Выйти</a>
                    <button type="submit" id="save_button" class="btn btn-primary" disabled="true"><i class="fa fa-save"> </i> Сохранить</button>

                    <input type="hidden" name="task" value="user.update" />
                </form>

                <form action="<?php JRoute::_("index.php"); ?>" method="post" id="logoffForm">
                    <input type="hidden" name="task" value="user.logoff" />
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-images"> </i> Водительское удостоверение
                </button>
            </h2>
        </div>

        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                <div class="row" style="margin-bottom: 50px;">
                    <div class="col-sm-4" style="display: none;">
                        <div class="card">
                            <img src="" id="license1" class="card-img-top" alt="Фотография прав (Лицевая сторона)">
                            <div class="card-body">
                                <p class="card-text">Фотография прав (Лицевая сторона)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4" style="display: none;">
                        <div class="card">
                            <img src="" id="license2" class="card-img-top" alt="Фотография прав (Оборотная сторона)">
                            <div class="card-body">
                                <p class="card-text">Фотография прав (Оборотная сторона)</p>
                            </div>
                        </div>
                    </div>
                    <?php if ((empty($this->license1)) || (empty($this->license2))) : ?>
                        <div class="col-sm-4">
                            <div class="card">
                                <form id="upload-container" method="POST" prefix="1" action="<?php echo JRoute::_("index.php?option=com_shering&task=user.addImage&" . JSession::getFormToken() . "=1"); ?>">
                                    <span>Фотография прав</span>
                                    <span style="font-weight: bold;" id="appendLicenseSpan">(Лицевая сторона)</span><br />
                                    <label for="file-input"><i class="far fa-image" style="font-size: 40px;"> </i></label>
                                    <div class="text-center">
                                        <input id="file-input" type="file" name="file" accept="image/*;capture=camera">
                                        <label for="file-input">Выберите файл</label><br />
                                        <span>или перетащите его сюда</span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingThree">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <i class="fa fa-search"> </i> Заявка на автомобиль
                </button>
            </h2>
        </div>

        <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
                <div style="margin-bottom: 10px;">
                    <p style="text-align: right;" style="margin-bottom: 30px;">
                        <a class="" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Как это работает?</a>
                    </p>
                    <div class="row" style="margin-bottom: 30px;">
                        <div class="col">
                            <div class="collapse multi-collapse" id="multiCollapseExample1">
                                <div class="card card-body">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-3 col-xs-10" style="margin-bottom: 20px;">
                                            <i class="fa fa-list-ol" style="font-size: 48px;"> </i><br /><br />
                                            1. Заполняете анкету, выбираете характеристики автомобиля, которые Вам подходят
                                        </div>
                                        <div class="col-md-1 d-none d-lg-block d-xl-block" style="padding-top: 10px;">
                                            <i class="fa fa-angle-double-right" style="font-size: 28px;"> </i>
                                        </div>
                                        <div class="col-md-4 col-xs-10" style="margin-bottom: 20px;">
                                            <i class="fa fa-sms" style="font-size: 48px;"> </i><br /><br />
                                            2. Когда освобождается автомобиль с подходящими данными, мы Вам сообщаем
                                        </div>
                                        <div class="col-md-1 d-none d-lg-block d-xl-block" style="padding-top: 10px;">
                                            <i class="fa fa-angle-double-right" style="font-size: 28px;"> </i>
                                        </div>
                                        <div class="col-md-4 col-lg-3  col-xs-10">
                                            <i class="fa fa-truck-pickup" style="font-size: 48px;"> </i><br /><br />
                                            3. Управляете автомобилем своей мечты
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php foreach ($this->criteries as $criteria) : ?>
                        <div class="col-sm-4" style="margin-bottom: 30px;">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?php if (($criteria->mark == "") && ($criteria->model == "")) : ?>
                                            Любой автомобиль
                                        <?php else : ?>
                                            <?php echo $criteria->mark . " " . $criteria->model; ?>
                                        <?php endif; ?>
                                    </h5>
                                    <ul class="list-group list-group-flush">
                                        <?php if ($criteria->class != -1) : ?>
                                            <li class="list-group-item">
                                                Класс: <b>
                                                    <?php
                                                    switch ($criteria->class) {
                                                        case 1 : echo "Комфорт"; break;
                                                        case 2 : echo "Бизнес"; break;
                                                        default : echo "Эконом";
                                                    }
                                                    ?>
                                                </b>
                                            </li>
                                        <?php endif; ?>

                                        <li class="list-group-item">Год выпуска: <b>от <?php echo $criteria->year; ?> г.</b></li>

                                        <?php if ($criteria->engine_type != -1) : ?>
                                            <li class="list-group-item">
                                                Тип двигателя: <b>
                                                    <?php
                                                    switch ($criteria->engine_type) {
                                                        case 1 : echo "Пропан"; break;
                                                        case 2 : echo "Метан"; break;
                                                        case 2 : echo "Дизель"; break;
                                                        default : echo "Бензин";
                                                    }
                                                    ?>
                                                </b>
                                            </li>
                                        <?php endif; ?>

                                        <?php if ($criteria->engine_size != "") : ?>
                                            <li class="list-group-item">Объем двигателя: <b><?php echo $criteria->engine_size; ?></b></li>
                                        <?php endif; ?>

                                        <?php if ($criteria->transmission != -1) : ?>
                                            <li class="list-group-item">
                                                Коробка передач: <b>
                                                    <?php
                                                    switch ($criteria->transmission) {
                                                        case 1 : echo "Автомат"; break;
                                                        default : echo "Механическая";
                                                    }
                                                    ?>
                                                </b>
                                            </li>
                                        <?php endif; ?>

                                        <?php if ($criteria->interior != -1) : ?>
                                            <li class="list-group-item">
                                                Салон: <b>
                                                    <?php
                                                    switch ($criteria->interior) {
                                                        case 1 : echo "Кож. заменитель"; break;
                                                        case 2 : echo "Кожа"; break;
                                                        default : echo "Велюр";
                                                    }
                                                    ?>
                                                </b>
                                            </li>
                                        <?php endif; ?>

                                        <?php if ($criteria->conditioner != -1) : ?>
                                            <li class="list-group-item">
                                                Кондиционер: <b>
                                                    <?php
                                                    switch ($criteria->conditioner) {
                                                        case 1 : echo "Есть"; break;
                                                        default : echo "Нет";
                                                    }
                                                    ?>
                                                </b>
                                            </li>
                                        <?php endif; ?>

                                        <?php if ($criteria->cost > 0) : ?>
                                            <li class="list-group-item">
                                                Цена до: <b><?php echo $criteria->cost; ?> руб./сут.</b>
                                            </li>
                                        <?php endif; ?>

                                        <li class="list-group-item">
                                            <a href="<?php echo JRoute::_("index.php?option=com_shering&task=criteria.delete&id=" . $criteria->id . "&" . JSession::getFormToken() . "=1"); ?>" class="btn btn-primary">
                                                <i class="fa fa-times"> </i> Удалить заявку
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php for ($i = count($this->criteries); $i < 3; $i++) : ?>
                        <div class="col-sm-4" style="margin-bottom: 30px;">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Новая заявка</h5>
                                    <p class="card-text">Для добавления заявки заполните анкету автомобиля...</p>
                                    <a href="<?php echo JRoute::_("index.php?option=com_shering&view=criteria"); ?>" class="btn btn-primary">
                                        <i class="fa fa-plus"> </i> Добавить заявку
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>



