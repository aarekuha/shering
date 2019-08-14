<?php
defined('_JEXEC') or die;

class TestingViewTickets extends JViewLegacy {
    protected $items;
    protected $pagination;
    protected $state;
    protected $token;

    public function display($tpl = null)
    {
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');

        return parent::display($tpl);
    }
}
?>