<?php
defined("_JEXEC") or die();

class SheringViewCriteries extends JViewLegacy {

    protected $items;
    protected $state;
    protected $listOrder;
    protected $listDirn;

    public $filterForm;
    public $activeFilters;

    protected $pagination;

    public function display($tpl = null)
    {
        $this->sidebar = SheringHelper::addSubMenu("criteries");
        $this->addToolBar();

        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->listOrder = $this->state->get('list.ordering');
        $this->listDirn = $this->state->get('list.direction');

        $this->pagination = $this->get('Pagination');

        $this->filterForm = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');

        parent::display($tpl);
    }

    protected function addToolBar()
    {
        JToolbarHelper::title(JText::_("COM_SHERING_CRITERIES_TITLE"));

        JToolbarHelper::deleteList('COM_SHERING_DELETE_CRITERIA_ASK', 'criteries.delete', "COM_SHERING_DELETE_CRITERIES");

        JToolBarHelper::preferences('com_shering');
    }
}
?>