<?php
defined('_JEXEC') or die;
?>

<table class="table table-striped table-hover">
    <tr>
        <th><?php echo JText::_('COM_TESTING_TICKETS_TABLE_TICKET'); ?></th>
        <th><?php echo JText::_('COM_TESTING_TICKETS_TABLE_DESC'); ?></th>
        <th><?php echo JText::_('COM_TESTING_TICKETS_TABLE_STATUS'); ?></th>
        <th><?php echo JText::_('COM_TESTING_TICKETS_TABLE_RATING'); ?></th>
    </tr>
    <?php if (empty($this->items)) : ?>
        <tr>
            <td colspan="4" style="text-align: center; font-style: italic; "><?php echo JText::_("COM_TESTING_TICKETS_EMPTY"); ?></td>
        </tr>
    <?php else : ?>
        <?php foreach ($this->items as $item) : ?>
            <?php
                $link = "";
                if (!$item->status) {
                    $link = "?option=com_testing&view=ticket&id=" . $item->id;
                    $link = " onclick=\"javascript:location.href='" . $link . "';\" style='cursor: pointer; font-weight: bold;'";
                }
            ?>
            <tr <?php echo $link; ?>>
            <td><?php echo $item->name; ?></td>
                <td><?php echo $item->value; ?></td>
                <td>
                    <?php
                    switch ($item->status) {
                        case 1: $ticketStatus = "<span style='color: #000000;'>" . JText::_('COM_TESTING_USER_TICKET_NOT_CHECKED') . "</span>"; break;
                        case 2: $ticketStatus = "<span style='color: #006400;'>" . JText::_('COM_TESTING_USER_TICKET_CHECKED') . "</span>"; break;
                        default: $ticketStatus = "<span style='color: #8b0000;'>" . JText::_('COM_TESTING_USER_TICKET_NOT_PASS') . "</span>"; break;
                    }
                    echo $ticketStatus;
                    ?>
                </td>
                <td>
                    <?php
                    if ($item->status == 2)
                        echo $item->rating ?
                            "<span style='color: #006400;'>" . JText::_('COM_TESTING_USER_TICKET_SUCCESS') . "</span>" :
                            "<span style='color: #8b0000;'>" . JText::_('COM_TESTING_USER_TICKET_FAIL') . "</span>";
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<?php echo $this->pagination->getListFooter(); ?>