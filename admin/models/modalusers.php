<?php

defined('_JEXEC') or die('Restricted access');

class SheringModelModalusers extends JModelList
{
    public function __construct($config = array())
    {
        $config['filter_fields'] = array('id');
        parent::__construct($config);
    }

    public function populateState($ordering = null, $direction = null)
    {
        parent::populateState('id', 'desc');
    }

    public function getListQuery()
    {
        $car_id = JFactory::getApplication()->input->get("car_id");
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("*")->from("#__shering_cars")->where("`id` = " . $db->quote($db->escape($car_id)));
        $db->setQuery($query);
        $car = $db->loadObject();

        $query = parent::getListQuery();

        $query->select("user_id, class, year, engine_type, transmission, interior, conditioner, date_format(creation_date, '%d.%m.%Y') as creation_date, cost");
        $query->from("#__shering_criteria as a");

        $query->select("fio, smscounter, tel");
        $query->join("left", "#__shering_users as users on (users.id = a.user_id)");

        $query->select("c.name as mark");
        $query->join("left", "#__shering_marks as c on (c.id = a.mark)");

        $query->select("d.name as model");
        $query->join("left", "#__shering_models as d on (d.id = a.model)");

        $query->select("e.name as engine_size");
        $query->join("left", "#__shering_engine_sizes as e on (e.id = a.engine_size)");

        $search = $query->escape($this->getState('filter.search'));
        if (!empty($search)) {
            $query->where('fio regexp "' . (string)$search . '" or
                                     tel regexp "' . (string)$search . '"');
        }

        $query->where("(`class` = " . $car->class . " or `class` = -1)");
        $query->where("(`mark` = " . $car->mark . " or `mark` = -1)");
        $query->where("(`model` = " . $car->model . " or `model` = -1)");
        $query->where("(`year` <= " . $car->year . ")");
        $query->where("(`engine_type` = " . $car->engine_type . " or `engine_type` = -1)");
        $query->where("(`engine_size` > " . $car->engine_size . " or `engine_size` = -1)");
        $query->where("(`transmission` = " . $car->transmission . " or `transmission` = -1)");
        $query->where("(`interior` = " . $car->interior . " or `interior` = -1)");
        $query->where("(`conditioner` = " . $car->conditioner . " or `conditioner` = -1)");
        $query->where("(`cost` >= " . $car->cost . " or `cost` = 0)");

        $query->where('(`deleted` != 1)');
        $query->where('(`status` = 1)');

        $query->order("smscounter ASC, creation_date ASC");

        return $query;
    }

}