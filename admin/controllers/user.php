<?php
defined("_JEXEC") or die();

class SheringControllerUser extends JControllerForm {
    public function resetCounter()
    {
        JSession::checkToken("get") or jexit('Invalid Token');

        $id  = JFactory::getApplication()->input->getString("id");

        $model = $this->getModel();
        $model->resetCounter($id);

        return true;
    }

    public function deletePhoto()
    {
        JSession::checkToken("get") or jexit('Invalid Token');

        $id  = JFactory::getApplication()->input->getString("id");
        $prefix  = JFactory::getApplication()->input->getString("prefix");

        $model = $this->getModel();
        $model->deletePhoto($id, $prefix);

        JFactory::getApplication()->redirect("index.php?option=com_shering&view=user&layout=edit&id=" . $id);
    }

}
?>
