<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');

$script = "function sendSms(_id, _senderId) {
                var _carId = " . $this->car_id . ";
                var jqAjax = jQuery.getJSON('/administrator/index.php?option=com_shering&task=users.sendSms&" . JSession::getFormToken() . "=1&user_id=' + _id + '&car_id=' + _carId);
                jqAjax.success(function (r) { 
                                    if (r) {
                                        alert(r.message); 
                                    }
                                });
                jqAjax.complete(function () {
                                    jQuery('#sendButton' + _senderId).attr('disabled', 'true');
                                    jQuery('#sendButton' + _senderId).attr('href', 'javascript:return false;');
                                    jQuery('#sendButton' + _senderId).css('background-color', 'grey');
                                    jQuery('#sendButton' + _senderId).html('" . JText::_("COM_SHERING_MODAL_USERS_SMS_SENDED") . "');
                                    jQuery('#badge' + _senderId).html(parseInt(jQuery('#badge' + _senderId).html()) + 1);
                                });  
            };";

JFactory::getDocument()->addScriptDeclaration($script);

?>

<form action="#" method="post" name="adminForm" id="adminForm">

    <?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th><?php echo JText::_("COM_SHERING_MODAL_USERS_TABLE_USER"); ?></th>
                <th><?php echo JText::_("COM_SHERING_MODAL_USERS_TABLE_CRITERIA"); ?></th>
                <th>SMS</th>
            </tr>
        </thead>

        <tbody>
        <?php $counter = 0; ?>
        <?php if (empty($this->items)) : ?>
            <tr>
                <td colspan="3" style="text-align: center; font-weight: bold;">Нет пользователей, заявки которых подходят под характеристики данного автомобиля...</td>
            </tr>
        <?php else : ?>
            <?php foreach ($this->items as $i => $item) : ?>
                <tr class="row<?php echo $i % 2; ?>">
                    <td>
                        <?php
                            echo JText::_("COM_SHERING_MODAL_USERS_CRITERIA_CREATION_DATE") . ": " . $item->creation_date . "<br />";
                            echo "<span class='badge badge-secondary' id='badge" . $counter . "'>" . $item->smscounter . "</span> " .$item->fio . " (+7" . $item->tel . ")";
                        ?>
                    </td>

                    <td>
                        <ul>

                        <?php
                            echo "<li><b>";

                            if (!empty($item->mark) || (!empty($item->model))) {
                                echo $item->mark . " " . $item->model;
                            } else {
                                echo JText::_("COM_SHERING_MODAL_USERS_ANY_CAR");
                            }

                            echo "</b></li>";
                        ?>

                        <?php
                            if ($item->class != "-1") {
                                echo "<li>";
                                    echo JText::_("COM_SHERING_FIELD_CLASS_NONE") . ": ";
                                    switch ($item->class) {
                                        case 1 : echo JText::_("COM_SHERING_FIELD_CLASS_1"); break;
                                        case 2 : echo JText::_("COM_SHERING_FIELD_CLASS_2"); break;
                                        default : echo JText::_("COM_SHERING_FIELD_CLASS_0");
                                    }
                                echo "</li>";
                            }
                        ?>

                        <?php
                            echo "<li>" . JText::_("COM_SHERING_CARS_TABLE_YEAR") . ": " . $item->year . "</li>";
                        ?>

                        <?php
                            if ($item->engine_type != "-1") {
                                echo "<li>";
                                    echo JText::_("COM_SHERING_CARS_TABLE_ENGINE_TYPE") . ": ";
                                    switch ($item->engine_type) {
                                        case 1 : echo JText::_("COM_SHERING_FIELD_ENGINE_TYPE_1"); break;
                                        case 2 : echo JText::_("COM_SHERING_FIELD_ENGINE_TYPE_2"); break;
                                        case 3 : echo JText::_("COM_SHERING_FIELD_ENGINE_TYPE_3"); break;
                                        default : echo JText::_("COM_SHERING_FIELD_ENGINE_TYPE_0");
                                    }
                                echo "</li>";
                            }
                        ?>

                        <?php
                            if ($item->engine_size != "") {
                                echo "<li>" . JText::_("COM_SHERING_CARS_TABLE_ENGINE_SIZE") . ": " . $item->engine_size . "</li>";
                            }
                        ?>

                        <?php
                            if ($item->transmission != "-1") {
                                echo "<li>";
                                    echo JText::_("COM_SHERING_CARS_TABLE_TRANSMISSION") . ": ";
                                    switch ($item->transmission) {
                                        case 1 : echo JText::_("COM_SHERING_FIELD_TRANSMISSION_1"); break;
                                        default : echo JText::_("COM_SHERING_FIELD_TRANSMISSION_0");
                                    }
                                echo "</li>";
                            }
                        ?>

                        <?php
                            if ($item->interior != "-1") {
                                echo "<li>";
                                    echo JText::_("COM_SHERING_CARS_TABLE_INTERIOR") . ": ";
                                    switch ($item->interior) {
                                        case 1 : echo JText::_("COM_SHERING_FIELD_INTERIOR_1"); break;
                                        case 2 : echo JText::_("COM_SHERING_FIELD_INTERIOR_2"); break;
                                        default : echo JText::_("COM_SHERING_FIELD_INTERIOR_0");
                                    }
                                echo "</li>";
                            }
                        ?>

                        <?php
                        if ($item->conditioner != "-1") {
                            echo "<li>" . JText::_("COM_SHERING_CARS_TABLE_CONDITIONER") . ": " . (($item->conditioner) ? "Есть" : "Нет") . "</li>";
                        }
                        ?>

                        <?php
                            if ($item->cost > 0) {
                                echo "<li>" . JText::_("COM_SHERING_CARS_TABLE_COST") . ": " . $item->cost . JText::_("COM_SHERING_COST_ADDITION"). "</li>";
                            }
                        ?>

                        </ul>
                    </td>

                    <td>
                        <a class="btn btn-success" id="sendButton<?php echo $counter; ?>" href="javascript:sendSms(<?php echo $item->user_id . ", " . $counter++; ?>);">
                            <?php echo JText::_("COM_SHERING_MODAL_USERS_SEND"); ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>

        <tfoot>


        </tfoot>
    </table>
    <div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>


