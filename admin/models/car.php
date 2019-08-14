<?php
defined("_JEXEC") or die();
use Joomla\Registry\Registry;

class SheringModelCar extends JModelAdmin {

    public function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm($this->option.".car",
                              "car",
                                       array('control' => 'jform',
                                             'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }

        return $form;
    }

    public function getTable($type = 'Car', $prefix = 'SheringTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function loadFormData()
    {
        $data = JFactory::getApplication()->getUserState('com_shering.edit.car.data', array());
        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }

    public function save($data)
    {
        $registry = new Registry;
        $registry->loadArray($data['images']);
        $data['images'] = (string)$registry;

        if (!parent::save($data)) {
            return false;
        }

        if ($data['id']) {
            return true;
        }  

        $data['id'] = JFactory::getDbo()->insertid();
        $path = JPATH_SITE . "/images/cars/";

        for ($i = 0; $i < 5; $i++) {
            if (file_exists($path . "_" . $i . ".png")) { 
                rename($path . "_" . $i . ".png", $path . $data['id'] . "_" . $i . ".png"); 
                $registry->set("image" . $i . "", $data['id'] . "_" . $i . ".png");
            }
        }

        $data['images'] = (string)$registry;

        return parent::save($data);
    }

    public function getItem($pk = null) {
        if($item = parent::getItem($pk)) {
            $registry = new Registry;
            $registry->loadString($item->images);
            $item->images = $registry->toArray();
        }
        return $item;
    }

    public function addImage($suffix)
    {
        error_reporting(E_ERROR | E_PARSE);
        $fn = $_FILES['images']['tmp_name'][0];
        $size = getimagesize($fn);
        $ratio = $size[0] / $size[1]; // width/height
        $params = JComponentHelper::getParams('com_shering');
        $maxSize = $params->get('maxSize');

        if ( $ratio > 1) {
            $width = $maxSize;
            $height = $maxSize / $ratio;
        }
        else {
            $width = $maxSize * $ratio;
            $height = $maxSize;
        }
        $src = imagecreatefromstring(file_get_contents($fn));
        $dst = imagecreatetruecolor($width, $height);

        imagealphablending( $dst, false );
        imagesavealpha( $dst, true );
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
        imagedestroy($src);
        imagepng($dst, $fn);
        imagedestroy($dst);

        $uploaddir = JPATH_SITE . '/images/cars/';
        $uploadfile = $uploaddir . $suffix . ".png";

        if (move_uploaded_file($fn, $uploadfile)) {
            echo $suffix . ".png";
        } else {
            echo "Возможная атака с помощью файловой загрузки!\n";
        }

        exit();
    }
}
?>
