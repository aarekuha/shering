<?php
defined('_JEXEC') or die;

class SheringModelCars extends JModelList {

    protected function getListQuery()
    {
        $query = parent::getListQuery();
        $query->select("a.id, class, year, engine_type, transmission, interior, conditioner, cost, images, status");
        $query->from("#__shering_cars as a");

        $query->select("b.name as mark");
        $query->join("left", "#__shering_marks as b on (a.mark = b.id)");

        $query->select("c.name as model");
        $query->join("left", "#__shering_models as c on (a.model = c.id)");

        $query->select("d.name as engine_size");
        $query->join("left", "#__shering_engine_sizes as d on (a.engine_size = d.id)");

        $input = JFactory::getApplication()->input;

        if ($input->get("allcars") != "1") {

            if ($input->get("status") != "on") {
                $query->where("a.status = 0");
            }

            $class = $input->get("class", "");
            $class = ($class === "") ? "1" : $query->quote($query->escape($class));
            $query->where("(a.class = " . $class . ")");

        }

        $query->order("class ASC, cost ASC, mark ASC, model ASC");

        $this->setState('list.limit', 200);

        return $query;
    }
}

?>