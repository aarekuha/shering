<?php
defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
?>
<h5 class="card-title" style="border-bottom: 1px solid black;"><i class="fa fa-plus"> </i> Новая заявка на автомобиль</h5>
<div class="row">

    <div class="alert alert-primary text-center" role="alert">
        Выберите только те характеристики, которые действительно важны для Вас! Большое количество выбранных параметров поиска уменьшает количество вариантов.
    </div>

    <form action="<?php echo JRoute::_("index.php?option=com_shering&view=criteria"); ?>" method="post" class="col-sm">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="class">Класс</label>
            </div>
            <select class="custom-select" id="class" name="class">
                <option value="-1"><?php echo JText::_('COM_SHERING_SHERING_LIST_DEFAULT_PLACEHOLDER'); ?></option>
                <option value="0">Эконом</option>
                <option value="1">Комфорт</option>
                <option value="2">Бизнес</option>
            </select>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="mark">Марка</label>
            </div>
            <script>
                function setModels() {
                    var mark_id = jQuery('#mark').val();
                    var models = jQuery('#carmodel' + mark_id);

                    jQuery('#model').children().each(function (index, el) {
                        var el = jQuery(this);
                        if (models.val().indexOf(el.html()) > -1) {
                            el.css('display', 'block');
                        } else {
                            el.css('display', 'none');
                        }
                        jQuery('#model').val('-1');
                    });
                }
            </script>
            <select class="custom-select" id="mark" name="mark" onchange="javascript:setModels(); return false;">
                <?php foreach ($this->marks as $mark) : ?>
                    <option value="<?php echo $mark->value; ?>"><?php echo $mark->text; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="model">Модель</label>
            </div>
            <select class="custom-select" id="model" name="model">
                <?php foreach ($this->models as $model) : ?>
                    <option value="<?php echo $model->value; ?>"><?php echo $model->text; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="year">Год выпуска от ...</label>
            </div>
            <input type="number" name="year" class="form-control" value="2015">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="engine_type">Тип двигателя</label>
            </div>
            <select class="custom-select" id="engine_type" name="engine_type">
                <option value="-1"><?php echo JText::_('COM_SHERING_SHERING_LIST_DEFAULT_PLACEHOLDER'); ?></option>
                <option value="0">Бензин</option>
                <option value="1">Пропан</option>
                <option value="2">Метан</option>
                <option value="3">Дизель</option>
            </select>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="engine_size">Объем двигателя</label>
            </div>
            <select class="custom-select" id="engine_size" name="engine_size">
                <?php foreach ($this->engine_sizes as $engine_size) : ?>
                    <option value="<?php echo $engine_size->value; ?>"><?php echo $engine_size->text; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="transmission">Коробка передач</label>
            </div>
            <select class="custom-select" id="transmission" name="transmission">
                <option value="-1"><?php echo JText::_('COM_SHERING_SHERING_LIST_DEFAULT_PLACEHOLDER'); ?></option>
                <option value="0">Механическая</option>
                <option value="1">Автомат</option>
            </select>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="interior">Салон</label>
            </div>
            <select class="custom-select" id="interior" name="interior">
                <option value="-1"><?php echo JText::_('COM_SHERING_SHERING_LIST_DEFAULT_PLACEHOLDER'); ?></option>
                <option value="0">Велюр</option>
                <option value="1" disabled="true">Кож. заменить</option>
                <option value="2">Кожа</option>
            </select>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="conditioner">Кондиционер</label>
            </div>
            <select class="custom-select" id="conditioner" name="conditioner">
                <option value="-1"><?php echo JText::_('COM_SHERING_SHERING_LIST_DEFAULT_PLACEHOLDER'); ?></option>
                <option value="0">Нет</option>
                <option value="1">Есть</option>
            </select>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="cost">Цена до ...</label>
            </div>
            <input type="number" name="cost" class="form-control" value="0">
        </div>

        <button type="submit" id="save_button" class="btn btn-primary"><i class="fa fa-plus"> </i> Сохранить</button>
        <a href="<?php echo JRoute::_("index.php?option=com_shering&view=user"); ?>" class="btn btn-primary"><i class="fa fa-times"> </i> Вернуться назад</a>

        <input type="hidden" name="task" value="criteria.append" />
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>


