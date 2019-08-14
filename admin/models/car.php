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
//        file_put_contents("/file.txt", $suffix);
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
        $dst = imagecreatetruecolor($width, $height);

        imagealphablending( $dst, false );
        imagesavealpha( $dst, true );
        imagecopyresampled($dst, $src,0,0,0,0, $width, $height, $size[0], $size[1]);
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
