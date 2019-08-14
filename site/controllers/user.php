<?php
defined('_JEXEC') or die;

require_once JPATH_COMPONENT_SITE . "/models/criteria.php";

class SheringControllerUser extends JControllerForm {

    public function getModel($name = 'User', $prefix = 'SheringModel', $config = array())
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function logoff() {
        $model = $this->getModel();
        $model->logoff();

        $app = JFactory::getApplication();
        $app->redirect(JRoute::_("index.php"));
    }

    public function update()
    {
        $model = $this->getModel();
        $model->update();
    }

    public function addImage()
    {
        JSession::checkToken("get") or jexit('ERROR');
        $prefix = JFactory::getApplication()->input->get("prefix");
        $token = JFactory::getApplication()->getUserState("shering_token");
        $id = SheringModelCriteria::getUserId($token);

        if ((($prefix != "1") && ($prefix != "2")) || empty($token) || empty($id)) {
            echo "ERROR";
            exit();
        }

        // Сжать картинку
        $fn = $_FILES['images']['tmp_name'][0];
        $size = getimagesize($fn);
        $ratio = $size[0] / $size[1]; // width/height
        if ( $ratio > 1) {
            $width = 1000;
            $height = 1000 / $ratio;
        }
        else {
            $width = 1000 * $ratio;
            $height = 1000;
        }
        $src = imagecreatefromstring(file_get_contents($fn));
        $dst = imagecreatetruecolor($width,$height);
        imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
        imagedestroy($src);
        imagepng($dst, $fn);
        imagedestroy($dst);

        $uploaddir = JPATH_COMPONENT_ADMINISTRATOR . '/images/licenses/';
        $uploadfile = $uploaddir . $id . "_" . $prefix . ".png";

        if (move_uploaded_file($fn, $uploadfile)) {
            echo JUri::base() . "administrator/components/com_shering/images/licenses/" . $id . "_" . $prefix . ".png";
        } else {
            echo "Возможная атака с помощью файловой загрузки!\n";
        }

        exit();
    }
}