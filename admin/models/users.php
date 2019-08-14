<?php
defined("_JEXEC") or die();

require_once JPATH_COMPONENT_SITE . "/models/user.php";

class SheringModelUsers extends JModelList {

    public function __construct($config = array())
    {
        $config['filter_fields'] = array('id', 'fio', 'tel', 'smscounter', 'status', 'registration_date');
        parent::__construct($config);
    }

    public function delete($pk = null)
    {
        parent::delete($pk);
    }

    public function getListQuery()
    {
        $query = parent::getListQuery();

        $query->select("id, fio, tel, smscounter, status, registration_date");
        $query->from("#__shering_users");

        $search = $query->escape($this->getState('filter.search'));
        if (!empty($search)) {
            $query->having('fio regexp "' . (string)$search . '" or 
                                      tel regexp "' . (string)$search . '"');
        }

        if ($this->getState('filter.status') != "") {
            $search = (int)$this->getState('filter.status');
            $query->having('`status` = "' . (string)$search .'"');
        }

        $orderColumn = $query->escape($this->getState('list.ordering', 'id'));
        $orderDirection = $query->escape($this->getState('list.direction', 'asc'));
        $query->order($orderColumn . " " . $orderDirection);

        return $query;
    }

    public function populateState($ordering = "status, fio", $direction = "asc, asc")
    {
        parent::populateState("status", "asc");
    }

    public function sendSms($user_id, $car_id)
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select("tel")->from("#__shering_users")->where("`id` = " . $db->quote($db->escape($user_id)));
        $db->setQuery($query);
        $tel = $db->loadResult();
        if (empty($tel)) {
            return;
        }

        $query = $db->getQuery(true);
        $query->select("a.cost")
              ->from("#__shering_cars as a");

        $query->select("b.name as mark")
              ->join("left", "#__shering_marks as b on (a.mark = b.id)");

        $query->select("c.name as model")
              ->join("left", "#__shering_models as c on (a.model = c.id)");

        $query->where("a.id = " . $db->quote($db->escape($car_id)));

        $db->setQuery($query);
        $car = $db->loadObject();

        if (!$car) {
            return;
        }

        $text = "Освободился " . $car->mark . " " . $car->model . ", " . $car->cost . "р.";

        echo SheringModelUser::sendSms($tel, $text);
    }

    public function incSmscounter($user_id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update("#__shering_users")
              ->set("`smscounter` = `smscounter` + 1")
              ->where("`id` = " . $db->quote($db->escape($user_id)));
        $db->setQuery($query);
        $db->execute();
    }
}

?>
