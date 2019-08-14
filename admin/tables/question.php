<?php
defined("_JEXEC") or die();

class TestingTableQuestion extends JTable {
    public function __construct($db)
    {
        parent::__construct('#__test_questions', 'id', $db);
    }

    public function bind($array, $ignore = array())
    {
        return parent::bind($array, $ignore);
    }

    public function load($pk = null, $reset = true)
    {
        return parent::load($pk, $reset);
    }
}
?>
