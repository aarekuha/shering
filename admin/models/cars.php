<?php
defined("_JEXEC") or die();

class SheringModelCars extends JModelList {

    public function __construct($config = array())
    {
        $config['filter_fields'] = array('id', 'class', 'year', 'engine_type', 'engine_size', 'transmission', 'interior', 'mark', 'model', 'cost', 'conditioner', 'car_number', 'status');
        parent::__construct($config);
    }

    public function getListQuery()
    {
        $query = parent::getListQuery();

        $query->select("a.id, class, year, engine_type, transmission, interior, conditioner, cost, images, car_number, status");
        $query->from("#__shering_cars as a");

        $query->select("b.name as mark");
        $query->join("left", "#__shering_marks as b on (a.mark = b.id)");

        $query->select("c.name as model");
        $query->join("left", "#__shering_models as c on (a.model = c.id)");

        $query->select("d.name as engine_size");
        $query->join("left", "#__shering_engine_sizes as d on (a.engine_size = d.id)");

        $search = $query->escape($this->getState('filter.search'));
        if (!empty($search)) {
            $query->having('b.name regexp "' . (string)$search . '" or 
                                      c.name regexp "' . (string)$search . '"');
        }

        if ($this->getState('filter.class') != "") {
            $search = (int)$this->getState('filter.class');
            $query->having('`class` = "' . $search . '"');
        }

        if ($this->getState('filter.engine_type') != "") {
            $search = (int)$this->getState('filter.engine_type');
            $query->having('`engine_type` = "' . $search . '"');
        }

        if ($this->getState('filter.transmission') != "") {
            $search = (int)$this->getState('filter.transmission');
            $query->having('`transmission` = "' . $search . '"');
        }

        if ($this->getState('filter.interior') != "") {
            $search = (int)$this->getState('filter.interior');
            $query->having('`interior` = "' . $search . '"');
        }

        if ($this->getState('filter.conditioner') != "") {
            $search = (int)$this->getState('filter.conditioner');
            $query->having('`conditioner` = "' . $search . '"');
        }

        if ($this->getState('filter.status') != "") {
            $search = (int)$this->getState('filter.status');
            $query->having('`status` = "' . $search . '"');
        }

        $orderColumn = $query->escape($this->getState('list.ordering', 'id'));
        $orderDirection = $query->escape($this->getState('list.direction', 'desc'));
        $query->order($orderColumn." ".$orderDirection);

        return $query;
    }

    public function populateState($ordering = null, $direction = null)
    {
        parent::populateState('id', 'desc');
    }
}

?>
