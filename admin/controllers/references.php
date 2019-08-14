<?php
defined("_JEXEC") or die();

class SheringControllerReferences extends JControllerAdmin {
    public function getModel($name = 'References', $prefix = 'SheringModel', $config = array())
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function insertName()
    {
        JSession::checkToken("get") or jexit('Invalid Token');

        $name  = JFactory::getApplication()->input->getString("name");
        $tableName  = JFactory::getApplication()->input->getString("tableName");

        $model = $this->getModel();
        $model->insertName($name, $tableName);

        return true;
    }

    public function removeName()
    {
        JSession::checkToken("get") or jexit('Invalid Token');

        $name  = JFactory::getApplication()->input->getString("name");
        $tableName  = JFactory::getApplication()->input->getString("tableName");

        $model = $this->getModel();
        $model->removeName($name, $tableName);

        return true;
    }
}

?>
