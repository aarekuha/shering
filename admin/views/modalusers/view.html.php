<?php
defined("_JEXEC") or die();

class SheringViewModalusers extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;
    protected $car_id;

    public function display($tpl = null)
    {
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->filterForm = $this->get('FilterForm');
        $this->car_id = JFactory::getApplication()->input->get("car_id");

        JFactory::getApplication()->input->set('hidemainmenu', true);

        parent::display($tpl);

    }
}
