<?php
defined("_JEXEC") or die();

class SheringTableUser extends JTable {
    public function __construct($db)
    {
        parent::__construct('#__shering_users', 'id', $db);
    }
}
?>
