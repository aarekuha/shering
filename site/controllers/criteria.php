<?php
defined('_JEXEC') or die;

class SheringControllerCriteria extends JControllerForm {

    public function getModel($name = 'Criteria', $prefix = 'SheringModel', $config = array())
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function append() {
        JSession::checkToken() or die();

        $model = $this->getModel();
        $model->append();

        JFactory::getApplication()->redirect(JRoute::_("index.php?option=com_shering&view=user"));
    }

    public function delete() {
        JSession::checkToken("get") or jexit('Invalid Token');

        $id  = JFactory::getApplication()->input->getString("id");
        if (empty($id)) {
            return;
        }

        $model = $this->getModel();
        $model->delete($id);

        JFactory::getApplication()->redirect(JRoute::_("index.php?option=com_shering&view=user"));
    }
}