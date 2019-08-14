<?php
defined("_JEXEC") or die();

// JFormHelper::loadFieldClass("list");
jimport('joomla.form.formfield');

class JFormFieldAnswers extends JFormField {

    protected $type = "Answers";

    protected function getInput()
    {
        $script = array();
        $script[] = '
                    var counter = 0;
                    function addItem(value = ""){
                        var ul = document.getElementById("' . $this->id . '");
                        var candidate = document.getElementById("candidate");
                        value = (value === "") ? candidate.value : value;
                        if (value == "") return;
                        var li = document.createElement("li");
                        li.setAttribute(\'value\', value);
            
                        var removeButton = document.createElement("i");
                        removeButton.setAttribute("class", "icon icon-trash");
                        removeButton.onclick = function () {
                            this.parentElement.parentElement.removeChild(this.parentElement);
                        };
            
                        li.appendChild(removeButton);
                        li.appendChild(document.createTextNode(value));
                        
                        var tempElement = document.createElement("input");
                        tempElement.setAttribute("type", "hidden");
                        tempElement.setAttribute("name", "' . $this->name . '[" + (counter++) + "]");
                        tempElement.setAttribute("value", value);
                        li.appendChild(tempElement);
                        
                        candidate.value = "";
                        ul.appendChild(li);
                    }';
        JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

        $style = array();
        $style[] = '.icon-trash {
                        cursor: pointer;
                        margin-right: 10px;
                    }';
        $style[] = '.btn-group i {
                        font-size: 10pt; 
                        cursor: pointer; 
                        margin-left: 10px;
                    }';
        JFactory::getDocument()->addStyleDeclaration(implode("\n", $style));

        $html[] = '<div class="btn-group">
                        <input type="text" id="candidate" />
                        <i class="icon icon-plus" onclick="javascript:addItem(); return false;"></i>                       
                   </div>
                   <ul id="' . $this->id . '" style="margin-top: 7px;"></ul>';

        return implode("\n", $html);
    }
}

?>