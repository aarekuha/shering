<?php
defined("_JEXEC") or die();

class SheringTableCriteria extends JTable {
    public function __construct($db)
    {
        parent::__construct('#__shering_criteria', 'id', $db);
    }
}
?>
