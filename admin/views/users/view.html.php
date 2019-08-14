<?php
defined("_JEXEC") or die();

class SheringViewUsers extends JViewLegacy {

    protected $items;
    protected $state;
    protected $listOrder;
    protected $listDirn;

    public $filterForm;
    public $activeFilters;

    protected $pagination;

    public function display($tpl = null)
    {
        $this->sidebar = SheringHelper::addSubMenu("users");
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
        JToolbarHelper::title(JText::_("COM_SHERING_USERS_TITLE"));

        JToolbarHelper::addNew('user.add', 'COM_SHERING_ADD_USER');
        JToolbarHelper::editList('user.edit', 'COM_SHERING_EDIT_USER');
        JToolbarHelper::deleteList('COM_SHERING_DELETE_USER_ASK', 'users.delete', "COM_SHERING_DELETE_USERS");

        JToolBarHelper::preferences('com_shering');
    }
}
?>