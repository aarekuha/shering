<?php
defined('_JEXEC') or die;

$input = JFactory::getApplication()->input;
$status = $input->get("status", "");
$class = $input->get("class", "-1");
$transmission = $input->get("transmission", "-1");
$engine_type = $input->get("engine_type", "-1");

if ($input->get("allcars") == "1") {
    $class = "-1";
    $status = "on";
    $transmission = "-1";
    $engine_type = "-1";
} 

$contacttelephone = JComponentHelper::getParams('com_shering')->get("contacttelephone");

?>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>
    
    <style>
        .modal-header {
            font-weight: bold;
        }
        .modal-body span {
            font-weight: bold;
        }
    </style>
    <script>
        function showDesc(id, header, modalClass, modalYear, modalEngineType, modalEngineSize, modalTransmission, modalInterior, 
                            modalConditioner, modalNumber, modalCost, tel, modalStatus, desc, img1, img2, img3, img4, img5) {
            let isReservable = (modalNumber.length > 4) && ((modalStatus == 1) || (modalStatus == 2));
            let baseReserveUrl = "https://autoshering.ru/index.php/component/shering/?view=user";
            
            jQuery('#modalReserve').attr("href", baseReserveUrl + "&reserve=" + id);
            jQuery('#modalReserve').css("display", isReservable ? "inline-block" : "none");
            jQuery('#exampleModalLongTitle').html(header);
            jQuery('#modalClass').html(modalClass);
            jQuery('#modalYear').html(modalYear);
            jQuery('#modalEngineType').html(modalEngineType);
            jQuery('#modalEngineSize').html(modalEngineSize);
            jQuery('#modalTransmission').html(modalTransmission);
            jQuery('#modalInterior').html(modalInterior);
            jQuery('#modalConditioner').html(modalConditioner);
            jQuery('#modalNumber').html(modalNumber);
            jQuery('#modalCost').html(modalCost + ' р/сут');
            jQuery('#callFromModal').html("Позвонить " + tel);
            jQuery('#callFromModal').attr("href", "tel:" + tel);
            jQuery('#modalDesc').html(desc);
            jQuery('#modalImgMain').attr("src", '/images/cars/' + img1);
            jQuery('#modalImg1').attr("src", '/images/cars/' + img1);
            jQuery('#modalImg2').attr("src", '/images/cars/' + img2);
            jQuery('#modalImg3').attr("src", '/images/cars/' + img3);
            jQuery('#modalImg4').attr("src", '/images/cars/' + img4);
            jQuery('#modalImg5').attr("src", '/images/cars/' + img5);
            jQuery('#modalImg2').css("display", img2 ? "inline-block" : "none");
            jQuery('#modalImg3').css("display", img3 ? "inline-block" : "none");
            jQuery('#modalImg4').css("display", img4 ? "inline-block" : "none");
            jQuery('#modalImg5').css("display", img5 ? "inline-block" : "none");
            jQuery('#modalImg1').hover(function(){ jQuery('#modalImgMain').attr("src", '/images/cars/' + img1); });
            jQuery('#modalImg2').hover(function(){ jQuery('#modalImgMain').attr("src", '/images/cars/' + img2); });
            jQuery('#modalImg3').hover(function(){ jQuery('#modalImgMain').attr("src", '/images/cars/' + img3); });
            jQuery('#modalImg4').hover(function(){ jQuery('#modalImgMain').attr("src", '/images/cars/' + img4); });
            jQuery('#modalImg5').hover(function(){ jQuery('#modalImgMain').attr("src", '/images/cars/' + img5); });
            
//            jQuery('#modalSlider').html(sliderObj.html());
            jQuery('#exampleModalCenter').modal('show');
        }
    </script>
    
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header" id="exampleModalLongTitle">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <h5 class="modal-title" i
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="modalBody">
                <div class="row">
                    <div id="modalSlider" class="col-lg-6 col-xl-4" style="margin-right: 30px; height: 330px;">
                        <img src="" id="modalImgMain" width="348" height="260" style="object-fit: cover;" /> <br />
                        <img src="" id="modalImg1" width="60" height="48" style="margin: 2px; object-fit: cover;" />
                        <img src="" id="modalImg2" width="60" height="48" style="margin: 2px; object-fit: cover;" />
                        <img src="" id="modalImg3" width="60" height="48" style="margin: 2px; object-fit: cover;" />
                        <img src="" id="modalImg4" width="60" height="48" style="margin: 2px; object-fit: cover;" />
                        <img src="" id="modalImg5" width="60" height="48" style="margin: 2px; object-fit: cover;" />
                    </div>
                    <div class="col-sm">
                        <ul>
                            <li>Класс: <span id="modalClass"></span></li>
                            <li>Год выпуска: <span id="modalYear"></span></li>
                            <li>Тип: <span id="modalEngineType"></span></li>
                            <li>Объем двигателя: <span id="modalEngineSize"></span></li>
                            <li>К/П: <span id="modalTransmission"></span></li>
                            <li>Салон: <span id="modalInterior"></span></li>
                            <li>Кондиционер: <span id="modalConditioner"></span></li>
                            <li>Гос. номер: <span id="modalNumber"></span></li>
                            <li>Цена: <span id="modalCost"></span></li>
                        </ul>                    
                    </div>
                </div>
                <div style="border: 1px solid gray; border-radius: 10px; padding: 20px 40px;">
                    Описание:<br /><span style="font-weight: normal;" id="modalDesc"></span>
                </div>
                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
              <a id="modalReserve" href="" class="btn btn-primary">Бронировать</a>
              <a id="callFromModal" href="" class="btn btn-primary">Позвонить</a>
            </div>
          </div>
        </div>
    </div>

    <div class="justify-content-center row">
        <h6 style="display: block;">Выберите фильтр автомобиля:</h6>
    </div>
    <div class="justify-content-center row" style="margin-bottom: 30px;">
        <form id="adminForm" name="adminForm" class="form-inline" action="index.php?option=com_shering&view=cars" method="post">
            <div class="btn-group btn-group-lg" role="group" style="margin-bottom: 10px;">
                <div class="btn-group mr-2" role="group">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-<?php echo ($class === "-1") ? "primary active" : "secondary"; ?>">
                            <input type="radio" name="class" <?php if ($class === "-1") echo " checked"; ?> onchange="javascript:$('#adminForm').submit();" value ="-1"> Все
                        </label>
                        <label class="btn btn-<?php echo ($class === "0") ? "primary active" : "secondary"; ?>">
                            <input type="radio" name="class" <?php if ($class === "0") echo " checked"; ?> onchange="javascript:$('#adminForm').submit();" value ="0"> Эконом
                        </label>
                        <label class="btn btn-<?php echo ($class === "1") ? "primary active" : "secondary"; ?>">
                            <input type="radio" name="class" <?php if ($class === "1") echo " checked"; ?> onchange="javascript:$('#adminForm').submit();" value ="1"> Комфорт
                        </label>
                        <label class="btn btn-<?php echo ($class === "2") ? "primary active" : "secondary"; ?>">
                            <input type="radio" name="class" <?php if ($class === "2") echo " checked"; ?> onchange="javascript:$('#adminForm').submit();" value ="2"> Бизнес
                        </label>
                    </div>
                </div>
            </div>
            <div class="btn-group btn-group-lg" role="group" style="margin-bottom: 10px;">
                <div class="btn-group mr-1" role="group">
                    <input type="checkbox" name="status"<?php if ($status == "on") echo " checked"; ?>
                           data-toggle="toggle" data-on="Свободные" data-off="Все" data-onstyle="success" data-offstyle="primary" onchange="javascript:$('#adminForm').submit();">
                </div>
            </div>
            <div class="btn-group btn-group-lg" role="group" style="margin-bottom: 10px;">
                <div class="btn-group mr-2" role="group">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-<?php echo ($transmission === "-1") ? "primary active" : "secondary"; ?>">
                            <input type="radio" name="transmission" <?php if ($transmission === "-1") echo " checked"; ?> onchange="javascript:$('#adminForm').submit();" value ="-1"> Все
                        </label>
                        <label class="btn btn-<?php echo ($transmission === "0") ? "primary active" : "secondary"; ?>">
                            <input type="radio" name="transmission" <?php if ($transmission === "0") echo " checked"; ?> onchange="javascript:$('#adminForm').submit();" value ="0"> Механическая
                        </label>
                        <label class="btn btn-<?php echo ($transmission === "1") ? "primary active" : "secondary"; ?>">
                            <input type="radio" name="transmission" <?php if ($transmission === "1") echo " checked"; ?> onchange="javascript:$('#adminForm').submit();" value ="1"> Автоматическая
                        </label>
                    </div>                    
                </div>
            </div>
            <div class="btn-group btn-group-lg" role="group" style="margin-bottom: 10px;">
                <div class="btn-group mr-2" role="group">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-<?php echo ($engine_type === "-1") ? "primary active" : "secondary"; ?>">
                            <input type="radio" name="engine_type" <?php if ($engine_type === "-1") echo " checked"; ?> onchange="javascript:$('#adminForm').submit();" value ="-1"> Все
                        </label>
                        <label class="btn btn-<?php echo ($engine_type === "0") ? "primary active" : "secondary"; ?>">
                            <input type="radio" name="engine_type" <?php if ($engine_type === "0") echo " checked"; ?> onchange="javascript:$('#adminForm').submit();" value ="0"> Бензин
                        </label>
                        <label class="btn btn-<?php echo ($engine_type === "1") ? "primary active" : "secondary"; ?>">
                            <input type="radio" name="engine_type" <?php if ($engine_type === "1") echo " checked"; ?> onchange="javascript:$('#adminForm').submit();" value ="1"> Пропан
                        </label>
                        <label class="btn btn-<?php echo ($engine_type === "2") ? "primary active" : "secondary"; ?>">
                            <input type="radio" name="engine_type" <?php if ($engine_type === "2") echo " checked"; ?> onchange="javascript:$('#adminForm').submit();" value ="2"> Метан
                        </label>
                        <label class="btn btn-<?php echo ($engine_type === "3") ? "primary active" : "secondary"; ?>">
                            <input type="radio" name="engine_type" <?php if ($engine_type === "3") echo " checked"; ?> onchange="javascript:$('#adminForm').submit();" value ="3"> Дизель
                        </label>
                    </div>                    
                </div>
            </div>
        </form>
    </div>
    <div class="justify-content-center row" style="margin: -30px 0px 20px;">
        <a href="index.php?option=com_shering&view=cars&allcars=1">Показать все автомобили...</a>
    </div>

<style>
    .carousel-control-prev, .carousel-control-next{
        background: rgba(100, 100, 100, 0.5);
    }
    .carousel-item {
        height: 260px;
    }
    .carousel-item1 img {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);
    }
    .carousel-item img { 
        height: 260px;
        width: 368px;
        object-fit: cover; 
    }
    .dot {
        vertical-align: middle;
        height: 20px;
        width: 50px;
        border-radius: 5px;
        display: inline-block;
        border: 1px solid gray;
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
                            $images = $item->images;
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
                        case 3 : echo JText::_("COM_SHERING_FIELD_STATUS_3"); break;
                        case 4 : echo JText::_("COM_SHERING_FIELD_STATUS_4"); break;
                        default : echo JText::_("COM_SHERING_FIELD_STATUS_0");
                    }
                    ?>
                </div>
            </div>

            <div class="card-body">
                <p class="card-text">
                    Класс: <b>
                        <?php
                            $carClass = "";
                            switch ($item->class) {
                                case 1 : $carClass = JText::_("COM_SHERING_FIELD_CLASS_1"); break;
                                case 2 : $carClass = JText::_("COM_SHERING_FIELD_CLASS_2"); break;
                                default : $carClass = JText::_("COM_SHERING_FIELD_CLASS_0");
                            }
                            echo $carClass;
                        ?></b><br />
                    Год выпуска: <b><?php echo $item->year; ?></b><br />
                    Тип: <b>
                        <?php
                            $engine_type = "";
                            switch ($item->engine_type) {
                                case 1 : $engine_type = JText::_("COM_SHERING_FIELD_ENGINE_TYPE_1"); break;
                                case 2 : $engine_type = JText::_("COM_SHERING_FIELD_ENGINE_TYPE_2"); break;
                                case 3 : $engine_type = JText::_("COM_SHERING_FIELD_ENGINE_TYPE_3"); break;
                                default : $engine_type = JText::_("COM_SHERING_FIELD_ENGINE_TYPE_0");
                            }
                            echo $engine_type;
                        ?></b><br />
                    Объем двигателя: <b><?php echo $item->engine_size; ?></b><br />
                    К/П: <b>
                    <?php
                            $transmission = ($item->transmission) ? JText::_("COM_SHERING_FIELD_TRANSMISSION_1") : JText::_("COM_SHERING_FIELD_TRANSMISSION_0");
                            echo $transmission;
                        ?></b><br />
                    <!--Цвет: <span class="dot" style="background-color: #<?php echo ($item->colorValue); ?>"></span><br />-->
                    Салон: <b>
                        <?php
                        $interior = "";
                        switch ($item->interior) {
                            case 1 : $interior = JText::_("COM_SHERING_FIELD_INTERIOR_1"); break;
                            case 2 : $interior = JText::_("COM_SHERING_FIELD_INTERIOR_2"); break;
                            default : $interior = JText::_("COM_SHERING_FIELD_INTERIOR_0");
                        }
                        echo $interior;
                        ?></b><br />
                    Кондиционер: <b><?php echo ($item->conditioner) ? "Есть" : "Нет"; ?></b><br />
                    Гос. номер: <b><?php echo ($item->car_number); ?></b><br />
                    Цена: <b><?php echo ($item->cost) . " р/сут"; ?></b>
                </p>

                <a href="javascript:showDesc('<?php echo $item->id; ?>', 
                                             '<?php echo $item->mark . " " . $item->model; ?>',
                                             '<?php echo ($carClass); ?>',
                                             '<?php echo ($item->year); ?>', 
                                             '<?php echo ($engine_type); ?>', 
                                             '<?php echo ($item->engine_size); ?>', 
                                             '<?php echo ($transmission); ?>', 
                                             '<?php echo ($interior); ?>', 
                                             '<?php echo ($item->conditioner) ? "Есть" : "Нет"; ?>', 
                                             '<?php echo ($item->car_number); ?>', 
                                             '<?php echo ($item->cost); ?>', 
                                             '<?php echo $contacttelephone; ?>',
                                             '<?php echo $item->status; ?>',
                                             '<?php echo htmlspecialchars($item->description); ?>',
                                             '<?php echo $images['image0']; ?>',
                                             '<?php echo $images['image1']; ?>',
                                             '<?php echo $images['image2']; ?>',
                                             '<?php echo $images['image3']; ?>',
                                             '<?php echo $images['image4']; ?>');" class="btn btn-sm btn-success">Подробнее...</a>
                <?php if ($item->status == 0) : ?>
                    <a href="tel:<?php echo $contacttelephone; ?>" class="btn btn-sm btn-primary callButton"><i class="fa fa-phone"> </i> Арендовать сейчас</a>
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
            $(this).html("Арендовать (<?php echo substr($contacttelephone, 0, 8) . "..."; ?>)");
            $(this).attr("href", "javascript:return false;");
            $(this).click(function() {
                $(this).html("<?php echo $contacttelephone; ?>");
                return false;
            });
        });
    }
</script>