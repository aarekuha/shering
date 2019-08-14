<?php
defined('_JEXEC') or die;

$input = JFactory::getApplication()->input;
$status = $input->get("status", "");
$class = $input->get("class", "");

if ($input->get("allcars") == "1") {
    $class = "";
    $status = "on";
} else if ($class === "") {
    $class = "1";
}

$contacttelephone = JComponentHelper::getParams('com_shering')->get("contacttelephone");

?>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>

    <div class="justify-content-center row">
        <h6 style="display: block;">Выберите категорию и статус автомобиля:</h6>
    </div>
    <div class="justify-content-center row" style="margin-bottom: 30px;">
        <form id="adminForm" name="adminForm" class="form-inline" action="index.php?option=com_shering&view=cars" method="post">
            <div class="btn-group btn-group-lg" role="group">
                <div class="btn-group mr-2" role="group">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-<?php echo ($class === "0") ? "primary active" : "secondary"; ?>">
                            <input type="radio" name="class" <?php if ($class == "0") echo " checked"; ?> onchange="javascript:$('#adminForm').submit();" value ="0"> Эконом
                        </label>
                        <label class="btn btn-<?php echo ($class === "1") ? "primary active" : "secondary"; ?>">
                            <input type="radio" name="class" <?php if ($class == "1") echo " checked"; ?> onchange="javascript:$('#adminForm').submit();" value ="1"> Комфорт
                        </label>
                        <label class="btn btn-<?php echo ($class === "2") ? "primary active" : "secondary"; ?>">
                            <input type="radio" name="class" <?php if ($class == "2") echo " checked"; ?> onchange="javascript:$('#adminForm').submit();" value ="2"> Бизнес
                        </label>
                    </div>

                    <input type="checkbox" name="status"<?php if ($status == "on") echo " checked"; ?>
                           data-toggle="toggle" data-on="Все" data-off="Свободные" data-onstyle="primary" data-offstyle="success" onchange="javascript:$('#adminForm').submit();">
                </div>
            </div>
        </form>
    </div>
    <div class="justify-content-center row" style="margin: -20px 0px 20px;">
        <a href="index.php?option=com_shering&view=cars&allcars=1">Показать все автомобили...</a>
    </div>

<style>
    .carousel-control-prev, .carousel-control-next{
        background: rgba(100, 100, 100, 0.5);
    }

</style>

<div class="row">
    <?php $sliderCounter = 0; ?>
    <?php if (!count($this->items)) : ?>
    <div class="col-sm-12 text-center" style="margin-bottom: 20px; height: 250px; padding-top: 100px;">
        <h5>Свободные автомобили выбранной категории отсутствуют...</h5>
    </div>
    <?php endif; ?>
    <?php foreach ($this->items as $item) : ?>
    <div class="col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 20px;">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <?php echo $item->mark . " " . $item->model; ?>
                </h5>
            </div>

            <div id="carouselExampleControls<?php echo ++$sliderCounter; ?>" class="card-img-top carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <?php
                            $item->images = (array)$item->images;
                            $imagesCount = 1;
                        ?>
                        <img src="/images/cars/<?php echo array_shift($item->images); ?>" class="d-block w-100" alt="<?php echo "Аренда " . $item->mark . " " . $item->model; ?>" >
                    </div>
                    <?php foreach ($item->images as $image) : ?>
                    <?php
                        if (empty($image)) { continue; }
                        $imagesCount++;
                    ?>
                    <div class="carousel-item">
                        <img src="/images/cars/<?php echo $image; ?>" class="d-block w-100" alt="<?php echo "Аренда " . $item->mark . " " . $item->model; ?>" >
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php if ($imagesCount > 1) : ?>
                    <a class="carousel-control-prev" href="#carouselExampleControls<?php echo $sliderCounter; ?>" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Назад</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls<?php echo $sliderCounter; ?>" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Следующий</span>
                    </a>
                <?php endif;?>
                <div class="card-img-overlay" style="text-shadow: 0px 0px 10px darkblue, 0px 0px 15px darkblue, 0px 0px 20px darkblue; font-weight: bold; color: white; <?php if ($imagesCount > 1) { echo "padding-left: 80px;"; } ?>">
                    <?php
                    switch ($item->status) {
                        case 1 : echo JText::_("COM_SHERING_FIELD_STATUS_1"); break;
                        case 2 : echo JText::_("COM_SHERING_FIELD_STATUS_2"); break;
                        default : echo JText::_("COM_SHERING_FIELD_STATUS_0");
                    }
                    ?>
                </div>
            </div>

            <div class="card-body">
                <p class="card-text">
                    Класс: <b>
                        <?php
                            switch ($item->class) {
                                case 1 : echo JText::_("COM_SHERING_FIELD_CLASS_1"); break;
                                case 2 : echo JText::_("COM_SHERING_FIELD_CLASS_2"); break;
                                default : echo JText::_("COM_SHERING_FIELD_CLASS_0");
                            }
                        ?></b><br />
                    Год выпуска: <b><?php echo $item->year; ?></b><br />
                    Тип: <b>
                        <?php
                            switch ($item->engine_type) {
                                case 1 : echo JText::_("COM_SHERING_FIELD_ENGINE_TYPE_1"); break;
                                case 2 : echo JText::_("COM_SHERING_FIELD_ENGINE_TYPE_2"); break;
                                case 3 : echo JText::_("COM_SHERING_FIELD_ENGINE_TYPE_3"); break;
                                default : echo JText::_("COM_SHERING_FIELD_ENGINE_TYPE_0");
                            }
                        ?></b><br />
                    Объем двигателя: <b><?php echo $item->engine_size; ?></b><br />
                    К/П: <b>
                    <?php
                            echo ($item->transmission) ? JText::_("COM_SHERING_FIELD_TRANSMISSION_1") : JText::_("COM_SHERING_FIELD_TRANSMISSION_0");
                        ?></b><br />
                    Салон: <b>
                        <?php
                        switch ($item->interior) {
                            case 1 : echo JText::_("COM_SHERING_FIELD_INTERIOR_1"); break;
                            case 2 : echo JText::_("COM_SHERING_FIELD_INTERIOR_2"); break;
                            default : echo JText::_("COM_SHERING_FIELD_INTERIOR_0");
                        }
                        ?></b><br />
                    Кондиционер: <b><?php echo ($item->conditioner) ? "Есть" : "Нет"; ?></b><br />
                    Цена: <b><?php echo ($item->cost) . " р/сут"; ?></b>
                </p>

                <?php if ($item->status == 0) : ?>
                    <a href="tel:<?php echo $contacttelephone; ?>" class="btn btn-primary callButton"><i class="fa fa-phone"> </i> Арендовать сейчас</a>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="row">
    <di class="col text-center">
        <i class="fa fa-question" style="font-size: 40px;"> </i><br />
        <h6>
            Не нашли тот автомобиль, который нужен?<br />
            <a href="/index.php?view=user">Оставьте заявку на автомобиль</a> и мы сообщим Вам, когда автомобиль появится!
        </h6>
    </di>
</div>

<script>
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        // код для мобильных устройств
    } else {
        $('.callButton').each(function () {
            $(this).html("Арендовать (<?php echo $contacttelephone; ?>)");
            $(this).attr("href", "javascript:return false;");
        });
    }
</script>