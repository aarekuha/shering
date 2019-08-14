<?php
defined('_JEXEC') or die;

class TestingViewTicket extends JViewLegacy
{
    protected $item;
    protected $state;

    public function display($tpl = null)
    {
        $this->item = $this->get("Item");
        $this->state = $this->get("State");

        parent::display($tpl);

        $this->setDocument();
    }

    protected function setDocument()
    {

    }
}