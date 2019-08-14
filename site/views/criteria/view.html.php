<?php
defined('_JEXEC') or die;

class SheringViewCriteria extends JViewLegacy
{
    protected $state;
    protected $token;
    protected $marks;
    protected $models;
    protected $engine_sizes;

    public function display($tpl = null)
    {
        $this->state = $this->get("State");

        $model = $this->getModel();
        $this->marks = $model->getOptions("marks");
        $this->models = $model->getOptions("models");
        $this->engine_sizes = $model->getOptions("engine_sizes");

        $this->token = JFactory::getApplication()->getUserState("shering_token");
        if (strlen($this->token) != 10) {
            JFactory::getApplication()->redirect(JRoute::_("index.php"));
            return;
        }

        $input = JFactory::getApplication()->input;
        $model = $this->getModel();


        parent::display($tpl);
    }
}