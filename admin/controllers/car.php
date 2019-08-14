<?php
defined("_JEXEC") or die();

class SheringControllerCar extends JControllerForm {

    public function addImage() {
        JSession::checkToken('get') or die();

        $suffix = JFactory::getApplication()->input->get("suffix");

        $model = $this->getModel();
        $model->addImage($suffix);
    }
}
?>
