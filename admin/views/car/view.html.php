<?php
defined("_JEXEC") or die();

class SheringViewCar extends JViewLegacy {

    protected $form = null;
    protected $item = null;

    public function display($tmpl = null)
    {
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');

        $this->addToolBar();

        parent::display($tmpl);
    }

    protected function addToolBar()
    {
        $isNew = ($this->item->id == 0);

        $title = ($isNew) ? JText::_("COM_SHERING_CAR_TITLE_NEW") : JText::_("COM_SHERING_CAR_TITLE_EDIT");
        $title = JText::_("COM_SHERING_CARS_TITLE") . " :: " . $title;
        JToolbarHelper::title($title);

        JToolbarHelper::save('car.save');
        JToolbarHelper::cancel('car.cancel');
    }
}
?>
