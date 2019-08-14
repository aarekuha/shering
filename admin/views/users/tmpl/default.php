<?php
defined("_JEXEC") or die();
use Joomla\Registry\Registry;
?>

<form action="<?php echo JRoute::_("index.php?option=com_shering&view=users"); ?>" method="post"
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
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_USERS_TABLE_FIO', 'fio', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_USERS_TABLE_TEL', 'tel', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_USERS_TABLE_SMSCOUNTER', 'smscounter', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_USERS_TABLE_STATUS', 'status', $this->listDirn, $this->listOrder); ?></th>
                <th><?php echo JHtml::_('grid.sort', 'COM_SHERING_USERS_TABLE_REGISTRATION_DATE', 'registration_date', $this->listDirn, $this->listOrder); ?></th>
            </thead>
            <tbody>
                <?php if (!empty($this->items)) : ?>
                    <?php foreach ($this->items as $key=>$item) : ?>
                        <?php
                            $link = JRoute::_('index.php?option=com_shering&view=user&layout=edit&id=' . $item->id);
                            $onclick = "javascript:document.location.href='" . $link . "'";
                            $style = "cursor: pointer;";
                        ?>
                        <tr>
                            <td><?php echo JHtml::_("grid.id", $key, $item->id); ?></td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>"><?php echo $item->fio; ?></td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>">
                                <?php echo "+7 (" . substr($item->tel, 0, 3) . ") ".
                                    substr($item->tel, 3, 3) . " " .
                                    substr($item->tel, 6, 2) . " " .
                                    substr($item->tel, 8, 2); ?>
                            </td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>"><?php echo $item->smscounter; ?></td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>">
                                <?php
                                    switch ($item->status) {
                                        case 1 : echo JText::_("COM_SHERING_FIELD_USER_STATUS_1"); break;
                                        case 2 : echo JText::_("COM_SHERING_FIELD_USER_STATUS_2"); break;
                                        default : echo JText::_("COM_SHERING_FIELD_USER_STATUS_0");
                                    }
                                ?>
                            </td>
                            <td onclick="<?php echo $onclick; ?>" style="<?php echo $style; ?>"><?php echo $item->registration_date; ?></td>
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
