<?php

defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

class JFormFieldSheringselect extends JFormFieldList {


    protected $type = 'Sheringselect';

    protected function getInput() {


        $tableName = $this->getAttribute("tablename");
        if ($tableName == "marks") {
            $script = "function setModels() {
                            var mark_id = jQuery('#jform_mark').val();
                            var models = jQuery('#carmodel' + mark_id);
                            
                            jQuery('#jform_model').children().each(function (index, el) {
                                var el = jQuery(this);
                                if (models.val().indexOf(el.html()) > -1) { 
                                    el.css('display', 'block');
                                } else {                                    
                                    el.css('display', 'none');
                                }
                                jQuery('#jform_model').val('0');
                            });

                       }";
            JFactory::getDocument()->addScriptDeclaration($script);
            $this->onchange = "javascript:setModels(); return false;";
        }

        return parent::getInput();
    }

    protected function getOptions() {

        $options = array();

        $db = JFactory::getDbo();
        $query = $db->getQuery(TRUE);

        $tableName = $this->getAttribute("tablename");

        $query->select('a.id as value, a.name as text');
        $query->from('#__shering_' . $tableName . " as a");

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
        $parent->value = 0;

        array_push($options,$parent);
        if($row) {
            for($i = 0; $i < count($row); $i++) {
                array_push($options, $row[$i]);
                if ($tableName == "marks") {
                    echo "<input type='hidden' value='" . $row[$i]->models . "' id='carmodel" . $row[$i]->value . "' />";
                }
            }
        }

        return $options;

    }
}
