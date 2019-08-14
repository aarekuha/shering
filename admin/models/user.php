<?php
defined("_JEXEC") or die();

require_once JPATH_COMPONENT_SITE . "/models/criteria.php";

class SheringModelUser extends JModelAdmin {

    public function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm($this->option.".user",
                              "user",
                                       array('control' => 'jform',
                                             'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }

        return $form;
    }

    public function getTable($type = 'User', $prefix = 'SheringTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }

    protected function loadFormData()
    {
        $data = JFactory::getApplication()->getUserState('com_shering.edit.user.data', array());

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }

    public function resetCounter($id)
    {
        if (empty($id)) {
            return;
        }

        $object = new stdClass();
        $object->id = JFactory::getDbo()->escape($id);
        $object->smscounter = 0;

        JFactory::getDbo()->updateObject('#__shering_users', $object, 'id');
    }

    public function save($data)
    {
        $data['tel'] = filter_var($data['tel'], FILTER_SANITIZE_NUMBER_INT);
        return parent::save($data);
    }

    public function delete(&$pks)
    {
        $isDeleted = parent::delete($pks);

        if ($isDeleted) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->delete("#__shering_criteria");
            $query->where("`user_id` in (" . implode(",", $pks) . ")");
            $db->setQuery($query);
            $db->execute();
        }

        return $isDeleted;
    }

    public function getLicenses()
    {
        $id = $this->getItem()->id;
        $path = JPATH_COMPONENT_ADMINISTRATOR . "/images/licenses/";
        $filePath = JUri::base() . "components/com_shering/images/licenses/";

        $license1 = (file_exists($path . $id . "_1.png")) ? $filePath . $id . "_1.png" : "";
        $license2 = (file_exists($path . $id . "_2.png")) ? $filePath . $id . "_2.png" : "";

        return array($license1, $license2);
    }

    public function deletePhoto($id, $prefix)
    {
        unlink(JPATH_COMPONENT_ADMINISTRATOR . "/images/licenses/" . $id . "_" . $prefix . ".png");
    }
}
?>
