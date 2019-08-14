<?php
defined("_JEXEC") or die();

class SheringModelReferences extends JModelList {

    public function getMarks()
    {
        return $this->getReference("marks");
    }

    public function getModels()
    {
        return $this->getReference("models");
    }

    public function getEngineSizes()
    {
        return $this->getReference("engine_sizes");
    }

    public function getReference($tableName)
    {
        if (empty($tableName)) {
            return;
        }

        if (($tableName != 'models') && ($tableName != 'marks') && ($tableName != 'engine_sizes')) {
            return;
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        if ($tableName == "models") {
            $query->select("a.id, concat(ifnull(b.name, 'Нет'), ' : ', a.name) as name");
            $query->from("#__shering_models as a");
            $query->join("left", "#__shering_marks as b on (a.mark = b.id)");
            $query->order("b.name, a.name");
        } else {
            $query->select("id, name");
            $query->from("#__shering_" . $tableName);
            $query->order("name");
        }

        $db->setQuery($query);

        return $db->loadObjectList();
    }

    public function insertName($name, $tableName)
    {
        if (empty($name)) {
            return;
        }

        if (($tableName != 'models') && ($tableName != 'marks') && ($tableName != 'engine_sizes')) {
            return;
        }

        $object = new stdClass();

        if ($tableName == "models") {
            $name = explode(" : ", $name);

            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select("id")->from("#__shering_marks")->where("`name` = " . $db->quote($db->escape($name[0])));
            $db->setQuery($query);
            $mark_id = $db->loadResult();

            if (empty($mark_id)) {
                return;
            }

            $name = $name[1];
            $object->mark = $mark_id;
        }

        $object->name = JFactory::getDbo()->escape($name);

        $tableName = JFactory::getDbo()->escape($tableName);

        JFactory::getDbo()->insertObject('#__shering_' . $tableName, $object, 'id');
    }

    public function removeName($name, $tableName)
    {
        if (empty($name)) {
            return;
        }

        if (($tableName != 'models') && ($tableName != 'marks') && ($tableName != 'engine_sizes')) {
            return;
        }

        if ($tableName == "models") {
            $name = (explode(" : ", $name))[1];
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->delete($db->quoteName('#__shering_' . $tableName));
        $query->where("`name` = " . $query->quote($name));
        $db->setQuery($query);
        $db->execute();
    }

}

?>
