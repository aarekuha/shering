<?php
defined("_JEXEC") or die();

class SheringViewReferences extends JViewLegacy {

    protected $marks;
    protected $models;
    protected $engine_sizes;

    public function display($tpl = null)
    {
        $this->sidebar = SheringHelper::addSubMenu("references");
        $this->addToolBar();

        $this->marks = $this->get("Marks");
        $this->models = $this->get("Models");
        $this->engine_sizes = $this->get("EngineSizes");

        parent::display($tpl);
    }

    protected function addToolBar()
    {
        JToolbarHelper::title(JText::_("COM_SHERING_CARS_TITLE"));
        JToolBarHelper::preferences('com_shering');
    }
}
?>