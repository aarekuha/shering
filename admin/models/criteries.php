<?php
defined("_JEXEC") or die();

class SheringModelCriteries extends JModelList {

    public function __construct($config = array())
    {
        $config['filter_fields'] = array('id', 'car_number', 'creation_date', 'fio', 'tel', 'class', 'year', 'engine_type', 'engine_size', 'transmission', 'interior', 'mark', 'model', 'cost', 'conditioner');
        parent::__construct($config);
    }

    public function getListQuery()
    {
        $query = parent::getListQuery();

        $query->select("a.id, a.class, a.year, a.engine_type, a.transmission, a.interior, a.conditioner, a.cost, DATE_FORMAT(creation_date, '%d.%m.%Y') as creation_date");
        $query->from("#__shering_criteria as a");

        $query->select("b.name as mark");
        $query->join("left", "#__shering_marks as b on (a.mark = b.id)");

        $query->select("c.name as model");
        $query->join("left", "#__shering_models as c on (a.model = c.id)");

        $query->select("d.name as engine_size");
        $query->join("left", "#__shering_engine_sizes as d on (a.engine_size = d.id)");

        $query->select("e.fio, e.tel, e.smscounter, e.status as user_status, e.id as user_id");
        $query->join("left", "#__shering_users as e on (a.user_id = e.id)");
        
        $query->select("f.car_number");
        $query->join("left", "#__shering_cars as f on (a.car_id = f.id)");
        
        $search = $query->escape($this->getState('filter.search'));
        if (!empty($search)) {
            $query->having('b.name regexp "' . (string)$search . '" or
                                      c.name regexp "' . (string)$search . '" or
                                      e.fio regexp "' . (string)$search . '" or
                                      e.tel regexp "' . (string)$search . '"');
        }

        if ($this->getState('filter.class') > -1) {
            $search = (int)$this->getState('filter.class');
            $query->having('`class` = "' . $search . '" or `class` = "-1"');
        }

        if ($this->getState('filter.engine_type') > -1) {
            $search = (int)$this->getState('filter.engine_type');
            $query->having('`engine_type` = "' . $search . '" or `engine_type` = "-1"');
        }

        if ($this->getState('filter.transmission') > -1) {
            $search = (int)$this->getState('filter.transmission');
            $query->having('`transmission` = "' . $search . '" or `transmission` = "-1"');
        }

        if ($this->getState('filter.interior') > -1) {
            $search = (int)$this->getState('filter.interior');
            $query->having('`interior` = "' . $search . '" or `interior` = "-1"');
        }

        if ($this->getState('filter.conditioner') > -1) {
            $search = (int)$this->getState('filter.conditioner');
            $query->having('`conditioner` = "' . $search . '" or `conditioner` = "-1"');
        }

        $orderColumn = $query->escape($this->getState('list.ordering', 'id'));
        $orderDirection = $query->escape($this->getState('list.direction', 'desc'));
        $query->order($orderColumn." ".$orderDirection);

        $query->where("`deleted` != 1");

        return $query;
    }

    public function populateState($ordering = null, $direction = null)
    {
        parent::populateState('id', 'desc');
    }

    public function delete(&$pks)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('#__shering_criteria'))
              ->set('`deleted` = 1')
              ->where('`id` in (' . implode(', ', $pks) . ')');
        $db->setQuery($query);
        $db->execute();

        return true;
    }
}

?>
