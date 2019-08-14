<?php
defined("_JEXEC") or die();

class TestingTableTicket extends JTable {
    public function __construct($db)
    {
        parent::__construct('#__test_tickets', 'id', $db);
    }
}
?>
