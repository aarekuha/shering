<?php
defined("_JEXEC") or die();

// JFormHelper::loadFieldClass("list");
jimport('joomla.form.formfield');

class JFormFieldSmscounter extends JFormField {

    protected $type = "Smscounter";

    protected function getInput()
    {
        $id = (int)$this->form->getValue("id");
        $smscounter = (int)$this->form->getValue("smscounter");
        $emptyButton = "<span style='color: green;'>" . JText::_("COM_SHERING_SMSCOUNTER_0") . "</span>";

        if ($smscounter == 0) {
            return $emptyButton;
        }

        $script = array();
        $script[] = '
            function resetCounter(_userId, _sender) {
                jQuery.getJSON("index.php?option=com_shering&task=user.resetCounter&' . JSession::getFormToken() . '=1&id=" + _userId, function (responce) {});
             }';
        JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

        $resetButton = " <button onclick='javascript:resetCounter(\"" . $id . "\", this);return true;'><span class='icon icon-loop'> </span> </button>";

        if ($smscounter == 1) {
            return "<span style='color: green;'>" . JText::_("COM_SHERING_SMSCOUNTER_1") . "</span>" . $resetButton;
        }

        if ($smscounter == 1) {
            return "<span style='color: brown;'>" . JText::_("COM_SHERING_SMSCOUNTER_2") . "Отправлено 2 СМС</span>" . $resetButton;
        }

        return "<span style='color: red; font-weight: bold;'>" . JText::_("COM_SHERING_SMSCOUNTER_3") . "</span>" . $resetButton;

        $script = array();
        $script[] = 'function jSelectBook_'.$this->id.'(id, name, object) {';
        $script[] = '    document.id("'.$this->id.'_id").value = id;';
        $script[] = '    document.id("'.$this->id.'_name").value = name;';
        $script[] = '    SqueezeBox.close();';
        $script[] = '}';

        // Add to document head
        JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

        // Setup variables for display
        $html = array();
        $link = 'index.php?option=com_testing&view=modaltickets&layout=modal'.
            '&tmpl=component&function=jSelectBook_'.$this->id;

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('name');
        $query->from('#__test_tickets');
        $query->where('id = '.(int)$this->value);
        $db->setQuery($query);
        $name = $db->loadResult();

        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

        $html[] = '<div>';
        $html[] = '  <a class="modal" href="' . $link . '" rel="{handler: \'iframe\', size: {x:1024, y:768}}">
                        <input style="cursor: pointer!important;" type="text" id="'.$this->id.'_name" value="'.$name.'" disabled="disabled" size="35" />
                     </a>';
        $html[] = '</div>';

        // The active book id field
        if (0 == (int)$this->value) {
            $value = '';
        } else {
            $value = (int)$this->value;
        }

        // class='required' for client side validation
        $class = '';
        if ($this->required) {
            $class = ' class="required modal-value"';
        }

        $html[] = '<input type="hidden" id="'.$this->id.'_id"'.$class.' name="'.$this->name.'" value="'.$value.'" />';

        return implode("\n", $html);
    }
}

?>