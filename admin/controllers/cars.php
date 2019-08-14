<?php
defined("_JEXEC") or die();

class SheringControllerCars extends JControllerAdmin {
    public function getModel($name = 'Car', $prefix = 'SheringModel', $config = array())
    {
        return parent::getModel($name, $prefix, $config);
    }
}

?>
