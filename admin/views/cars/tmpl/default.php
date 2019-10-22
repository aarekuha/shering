<?php
defined("_JEXEC") or die();
use Joomla\Registry\Registry;
JHtml::_('behavior.modal', 'a.modal');
?>

<style>
    .dot {
        height: 25px;
        width: 25px;
        margin: 3px;
        border-radius: 50%;
        display: inline-block;
        border: 1px solid gray;
        opacity: 0.5;
    }
    .dot:hover {
        opacity: 1;
    }
</style>

<form action="<?php echo JRoute::_("index.php?option=com_shering&view=cars"); ?>" method="post"
             name="adminForm" id="adminForm">
    <?php if (!empty($this->sidebar)) : ?>
        <div id="j-sidebar-container" class="span2">
            <?php echo $this->sidebar; ?>
        </div>
    <?php endif; ?>

    <div id="j-main-container" class="span10">

        <?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

        <table class="table table-striped table-hover">
            <thead>
                <th width="30px"> </th>
                <th width="50px"> </th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_CAR_NUMBER', 'car_number', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_MARK', 'mark', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_MODEL', 'model', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_CLASS', 'class', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_YEAR', 'year', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_ENGINE_TYPE', 'engine_type', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_ENGINE_SIZE', 'engine_size', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_TRANSMISSION', 'transmission', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JText::_('COM_SHERING_COLOR'); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_INTERIOR', 'interior', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_CONDITIONER', 'conditioner', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_COST', 'cost', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_STATUS', 'status', $this->listDirn, $this->listOrder); ?></th>
            </thead>
            <tbody>
                <?php if (!empty($this->items)) : ?>
                    <?php foreach ($this->items as $key=>$item) : ?>
                        <?php
                            $link = JRoute::_('index.php?option=com_shering&view=car&layout=edit&id=' . $item->id);
                            $onclick = "javascript:document.location.href='" . $link . "'";
                            $style = "cursor: pointer;";
                        ?>
                        <tr>
                            <td><?php echo JHtml::_("grid.id", $key, $item->id); ?></td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>">
                                <?php
                                    $registry = new Registry;
                                    $registry->loadString($item->images);
                                    $imageSrc = $registry->toArray()['image0'];
                                ?>
                                <?php $imageSrc = (substr( $imageSrc, 0, 4 ) === "http") ? $imageSrc : "/" . $imageSrc; ?>
                                <img src="/images/cars/<?php echo $imageSrc; ?>" alt="">
                            </td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>"><?php echo $item->car_number; ?></td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>"><?php echo $item->mark; ?></td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>"><?php echo $item->model; ?></td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>">
                                <?php
                                    switch ($item->class) {
                                        case 1 : echo JText::_("COM_SHERING_FIELD_CLASS_1"); break;
                                        case 2 : echo JText::_("COM_SHERING_FIELD_CLASS_2"); break;
                                        default : echo JText::_("COM_SHERING_FIELD_CLASS_0");
                                    }
                                ?>
                            </td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>"><?php echo $item->year; ?></td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>">
                                <?php
                                switch ($item->engine_type) {
                                    case 1 : echo JText::_("COM_SHERING_FIELD_ENGINE_TYPE_1"); break;
                                    case 2 : echo JText::_("COM_SHERING_FIELD_ENGINE_TYPE_2"); break;
                                    case 3 : echo JText::_("COM_SHERING_FIELD_ENGINE_TYPE_3"); break;
                                    default : echo JText::_("COM_SHERING_FIELD_ENGINE_TYPE_0");
                                }
                                ?>
                            </td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>"><?php echo $item->engine_size; ?></td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>"><?php echo ($item->transmission) ? JText::_("COM_SHERING_FIELD_TRANSMISSION_1") : JText::_("COM_SHERING_FIELD_TRANSMISSION_0"); ?></td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>">
                                <?php if ($item->colorValue) : ?>
                                <span class="dot" style="background-color: #<?php echo $item->colorValue; ?>"</span>
                                <?php endif; ?>
                            </td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>">
                                <?php
                                switch ($item->interior) {
                                    case 1 : echo JText::_("COM_SHERING_FIELD_INTERIOR_1"); break;
                                    case 2 : echo JText::_("COM_SHERING_FIELD_INTERIOR_2"); break;
                                    default : echo JText::_("COM_SHERING_FIELD_INTERIOR_0");
                                }
                                ?>
                            </td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>"><?php echo ($item->conditioner) ? "<span class='icon-checkmark'></span>" : "<span class='icon-cancel-2'></span>"; ?></td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>"><?php echo $item->cost . JText::_("COM_SHERING_COST_ADDITION"); ?></td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>">
                                <?php
                                switch ($item->status) {
                                    case 1 : echo JText::_("COM_SHERING_FIELD_STATUS_1"); break;
                                    case 2 : echo JText::_("COM_SHERING_FIELD_STATUS_2"); break;
                                    case 3 : echo JText::_("COM_SHERING_FIELD_STATUS_3"); break;
                                    case 4 : echo JText::_("COM_SHERING_FIELD_STATUS_4"); break;
                                    default : $listLink = JRoute::_("index.php?option=com_shering&tmpl=component&view=modalusers&car_id=" . $item->id);
                                              $modalAttr = 'rel="{handler: \'iframe\', size: {x:1024, y:768}}"';
                                              echo "<a href='" . $listLink . "' class='btn btn-success modal' " . $modalAttr . ">" . JText::_("COM_SHERING_FIELD_STATUS_0") . "</a>";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4">
                    <div class="span3">
                        <?php echo $this->pagination->getPagesCounter(); ?>
                    </div>
                    <div class="span9">
                        <?php echo $this->pagination->getListFooter(); ?>
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>

    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $this->listOrder; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $this->listDirn; ?>" />

    <?php echo JHtml::_("form.token"); ?>
</form>
