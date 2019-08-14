<?php
defined("_JEXEC") or die();

class TestingTableUserticket extends JTable {
    public function __construct($db)
    {
        parent::__construct('#__test_users_tickets', 'id', $db);
    }
}
?>
