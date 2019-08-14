<?php
defined("_JEXEC") or die();

class SheringControllerUsers extends JControllerAdmin {
    public function getModel($name = 'User', $prefix = 'SheringModel', $config = array())
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function sendSms()
    {
        $input = JFactory::getApplication()->input;
        $user_id = $input->get("user_id");
        $car_id = $input->get("car_id");

        $model = $this->getModel($name = 'Users', $prefix = 'SheringModel', $config = array());
        $model->sendSms($user_id, $car_id);

        $model->incSmscounter($user_id);

        exit();
    }
}

?>
