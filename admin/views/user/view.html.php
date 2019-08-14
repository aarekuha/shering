<?php
defined("_JEXEC") or die();

class SheringViewUser extends JViewLegacy {

    protected $form = null;
    protected $item = null;
    protected $license1 = "";
    protected $license2 = "";

    public function display($tmpl = null)
    {
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');
        list($this->license1, $this->license2) = $this->get("Licenses");

        $this->addToolBar();

        parent::display($tmpl);
    }

    protected function addToolBar()
    {
        $isNew = ($this->item->id == 0);

        $title = ($isNew) ? JText::_("COM_SHERING_USER_TITLE_NEW") : JText::_("COM_SHERING_USER_TITLE_EDIT");
        $title = JText::_("COM_SHERING_USERS_TITLE") . " :: " . $title;
        JToolbarHelper::title($title);

        JToolbarHelper::save('user.save');
        JToolbarHelper::cancel('user.cancel');
    }
}
?>
