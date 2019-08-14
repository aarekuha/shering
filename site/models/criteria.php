<?php
defined('_JEXEC') or die;

class SheringModelCriteria extends JModelLegacy
{
    public function getOptions($tableName) {

        $options = array();

        $db = JFactory::getDbo();
        $query = $db->getQuery(TRUE);

        $query->select('a.id as value, a.name as text');
        $query->from('#__shering_' . $tableName . ' as a');
        if ($tableName == "marks") {
            $query->select("group_concat(b.name ORDER BY b.name separator ',') as models");
            $query->join("left", "#__shering_models as b on (b.mark = a.id)");
            $query->group("a.name");
        }
        $query->order("a.name");

        $db->setQuery($query);

        $row = $db->loadObjectList();

        $parent = new stdClass;
        $parent->text = JText::_('COM_SHERING_SHERING_LIST_DEFAULT_PLACEHOLDER');
        $parent->value = "-1";

        array_push($options,$parent);
        if($row) {
            for($i = 0; $i < count($row);$i++) {
                array_push($options,$row[$i]);
                if ($tableName == "marks") {
                    echo "<input type='hidden' value='" . $row[$i]->models . "' id='carmodel" . $row[$i]->value . "' />";
                }
            }
        }

        return $options;
    }

    private function getCriteriesCount($token) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("COUNT(*)");
        $query->from("#__shering_criteria as a");
        $query->join("left", "#__shering_users as b on b.id = a.user_id");
        $query->where("`token` = " . $db->quote($token));
        $query->where("`deleted` != 1");
        $db->setQuery($query);
        return $db->loadResult();
    }

    static function getUserId($token) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("id");
        $query->from("#__shering_users");
        $query->where("`token` = " . $db->quote($token));
        $db->setQuery($query);
        return $db->loadResult();
    }

    public function append()
    {
        $token = JFactory::getApplication()->getUserState("shering_token");
        if ($this->getCriteriesCount($token) > 3) {
            return;
        }

        $input = JFactory::getApplication()->input;

        $criteria = new stdClass();
        $criteria->user_id = $this->getUserId($token);
        $criteria->class = $input->get("class");
        $criteria->mark = $input->get("mark");
        $criteria->model = $input->get("model");
        $criteria->year = $input->get("year");
        $criteria->engine_type = $input->get("engine_type");
        $criteria->engine_size = $input->get("engine_size");
        $criteria->transmission = $input->get("transmission");
        $criteria->interior = $input->get("interior");
        $criteria->conditioner = $input->get("conditioner");
        $criteria->creation_date = date("Y-m-d");
        $criteria->cost = $input->get("cost");

        JFactory::getDbo()->insertObject('#__shering_criteria', $criteria);
    }

    public function delete($id) {
        $token = JFactory::getApplication()->getUserState("shering_token");
        $user_id = $this->getUserId($token);

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('#__shering_criteria'))
            ->set('`deleted` = 1')
            ->where("`id` = " . $db->quote($id))
            ->where("`user_id` = " . $db->quote($user_id));
        $db->setQuery($query);
        $db->execute();
    }

}

?>