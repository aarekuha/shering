<?php
defined("_JEXEC") or die();

// JFormHelper::loadFieldClass("list");
jimport('joomla.form.formfield');

class JFormFieldQuestionparent extends JFormField {

    protected $type = "Questionparent";

    protected function getInput()
    {
        // Load modal behavior
        JHtml::_('behavior.modal', 'a.modal');

        // Build the script
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
        $link = 'index.php?option=com_testing&view=modaldocuments&layout=modal'.
            '&tmpl=component&function=jSelectBook_'.$this->id;

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('name');
        $query->from('#__test_documents');
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