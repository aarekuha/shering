<?php
defined("_JEXEC") or die();

class SheringViewCars extends JViewLegacy {

    protected $items;
    protected $state;
    protected $listOrder;
    protected $listDirn;

    public $filterForm;
    public $activeFilters;

    protected $pagination;

    public function display($tpl = null)
    {
        $this->sidebar = SheringHelper::addSubMenu("cars");
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
        JToolbarHelper::title(JText::_("COM_SHERING_CARS_TITLE"));

        JToolbarHelper::addNew('car.add', 'COM_SHERING_ADD_CAR');
        JToolbarHelper::editList('car.edit', 'COM_SHERING_EDIT_CAR');
        JToolbarHelper::deleteList('COM_SHERING_DELETE_CAR_ASK', 'cars.delete', "COM_SHERING_DELETE_CARS");

        JToolBarHelper::preferences('com_shering');
    }
}
?>