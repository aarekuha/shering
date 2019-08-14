<?php
defined("_JEXEC") or die();

class SheringTableCar extends JTable {
    public function __construct($db)
    {
        parent::__construct('#__shering_cars', 'id', $db);
    }
}
?>
