<?php
defined("_JEXEC") or die();
use Joomla\Registry\Registry;
?>

<form action="<?php echo JRoute::_("index.php?option=com_shering&view=criteries"); ?>" method="post"
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
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CRITERIA_TABLE_CREATION_DATE', 'creation_date', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CRITERIA_TABLE_FIO', 'fio', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CRITERIA_TABLE_TEL', 'tel', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_CLASS', 'class', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_MARK', 'mark', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_MODEL', 'model', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_YEAR', 'year', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_ENGINE_TYPE', 'engine_type', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_ENGINE_SIZE', 'engine_size', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_TRANSMISSION', 'transmission', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_INTERIOR', 'interior', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_CONDITIONER', 'conditioner', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_CARS_TABLE_COST', 'cost', $this->listDirn, $this->listOrder); ?></th>
            </thead>
            <tbody>
                <?php if (!empty($this->items)) : ?>
                    <?php foreach ($this->items as $key=>$item) : ?>
                        <?php
                            $rowStyle = "";
                            $badgeStyle = "";
                            if ($item->user_status == 2) {
                                // Пользователь заблокирован
                                $rowStyle .= "color: grey; text-decoration: line-through;";
                            }

                            if ($item->smscounter == 3) {
                                // Счетчик СМС достиг лимита
                                $rowStyle .= "text-decoration: line-through;";
                                $badgeStyle = "background-color: darkred;";
                            }

                            if ($item->user_status == 1) {
                                // Пользователь одобрен
                                $rowStyle .= "color: darkgreen; font-weight: bold;";
                            }
                        ?>
                        <tr style="<?php echo $rowStyle; ?>">
                            <td><?php echo JHtml::_("grid.id", $key, $item->id); ?></td>
                            <td><?php echo $item->creation_date; ?></td>
                            <?php $userLink = "index.php?option=com_shering&view=user&layout=edit&id=" . $item->user_id; ?>
                            <td>
                                <a href="<?php echo $userLink; ?>">
                                    <?php echo $item->fio . " <span class='badge' style='" . $badgeStyle . "'>" . $item->smscounter . "</span>"; ?>
                                </a>
                            </td>
                            <td><a href="<?php echo $userLink; ?>"><?php echo $item->tel; ?></a></td>

                            <td>
                                <?php
                                switch ($item->class) {
                                    case 0 : echo JText::_("COM_SHERING_FIELD_CLASS_0"); break;
                                    case 1 : echo JText::_("COM_SHERING_FIELD_CLASS_1"); break;
                                    case 2 : echo JText::_("COM_SHERING_FIELD_CLASS_2"); break;
                                    default : echo "";
                                }
                                ?>
                            </td>

                            <td><?php echo $item->mark; ?></td>
                            <td><?php echo $item->model; ?></td>

                            <td><?php echo $item->year; ?></td>

                            <td>
                                <?php
                                switch ($item->engine_type) {
                                    case 0 : echo JText::_("COM_SHERING_FIELD_ENGINE_TYPE_0"); break;
                                    case 1 : echo JText::_("COM_SHERING_FIELD_ENGINE_TYPE_1"); break;
                                    case 2 : echo JText::_("COM_SHERING_FIELD_ENGINE_TYPE_2"); break;
                                    case 3 : echo JText::_("COM_SHERING_FIELD_ENGINE_TYPE_3"); break;
                                    default : echo "";
                                }
                                ?>
                            </td>

                            <td><?php echo $item->engine_size; ?></td>

                            <td>
                                <?php
                                switch ($item->transmission) {
                                    case 0 : echo JText::_("COM_SHERING_FIELD_TRANSMISSION_0"); break;
                                    case 1 : echo JText::_("COM_SHERING_FIELD_TRANSMISSION_1"); break;
                                    default : echo "";
                                }
                                ?>
                            </td>

                            <td>
                                <?php
                                switch ($item->interior) {
                                    case 0 : echo JText::_("COM_SHERING_FIELD_INTERIOR_0"); break;
                                    case 1 : echo JText::_("COM_SHERING_FIELD_INTERIOR_1"); break;
                                    case 2 : echo JText::_("COM_SHERING_FIELD_INTERIOR_2"); break;
                                    default : echo "";
                                }
                                ?>
                            </td>

                            <td>
                                <?php
                                switch ($item->conditioner) {
                                    case 0 : echo "<span class='icon-cancel-2'></span>"; break;
                                    case 1 : echo "<span class='icon-checkmark'></span>"; break;
                                    default : echo "";
                                }
                                ?>

                            <td>
                                <?php
                                    if ($item->cost > 0 ) {
                                        echo $item->cost . JText::_("COM_SHERING_COST_ADDITION");
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
