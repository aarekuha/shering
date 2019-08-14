<?php
defined("_JEXEC") or die();

$token = JSession::getFormToken();

$script = array();
$script[] = '
            function insertName(_name, _tableName) {
                jQuery.getJSON("index.php?option=com_shering&task=references.insertName&' . $token . '=1&name=" + _name + "&tableName=" + _tableName, function (responce) {});
            }';

$script[] = '
            function removeName(_name, _tableName) {
                jQuery.getJSON("index.php?option=com_shering&task=references.removeName&' . $token . '=1&name=" + _name + "&tableName=" + _tableName, function (responce) {});
            }';

$script[] = '
            var counter = 0;
            function addItem(listId = "", value = ""){
                var ul = document.getElementById(listId);
                var candidate = document.getElementById(listId + "_input");
                var isNew = (value == "");
                value = (value == "") ? candidate.value : value;
                
                if (value == "") {
                    return;
                }
                
                if ((listId == "models") && isNew) {                    
                    value = jQuery("#marksSelect").val() + " : " + value;
                }
                                
                if (isNew) {
                    insertName(value, listId);
                }
                
                var li = document.createElement("li");
                li.setAttribute("value", value);
    
                var removeButton = document.createElement("i");
                removeButton.setAttribute("class", "icon icon-trash");
                removeButton.onclick = function () {
                    if (confirm("' . JText::_("COM_SHERING_CONFIRM_DELETE_FROM_REFERENCES") . '")) {
                        removeName(value, listId);
                        this.parentElement.parentElement.removeChild(this.parentElement);
                    }
                };
    
                li.appendChild(removeButton);
                li.appendChild(document.createTextNode(value));
                
                var tempElement = document.createElement("input");
                tempElement.setAttribute("type", "hidden");
                tempElement.setAttribute("name", listId + "[" + (counter++) + "]");
                tempElement.setAttribute("value", value);
                li.appendChild(tempElement);
                
                if (listId == "marks") {
                    jQuery("#marksSelect").append(new Option(value, value));
                }
                
                candidate.value = "";
                ul.appendChild(li);
            } ';

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

?>

    <?php if (!empty($this->sidebar)) : ?>
        <div id="j-sidebar-container" class="span2">
            <?php echo $this->sidebar; ?>
        </div>
    <?php endif; ?>

    <div id="j-main-container" class="span10">
        <div class="span4">
            <h3><?php echo JText::_("COM_SHERING_REFERENCES_MARKS_HEADER"); ?></h3>
            <div class="btn-group">
                <input type="text" id="marks_input" />
                <i class="icon icon-plus" onclick="javascript:addItem('marks'); return false;"></i>
            </div>
            <ul id="marks" style="margin-top: 7px;"></ul>
        </div>

        <div class="span4">
            <h3><?php echo JText::_("COM_SHERING_REFERENCES_MODELS_HEADER"); ?></h3>
            <div class="btn-group">
                <select type="select" id="marksSelect"></select><br />
                <input type="text" id="models_input" />
                <i class="icon icon-plus" onclick="javascript:addItem('models'); return false;"></i>
            </div>
            <ul id="models" style="margin-top: 7px;"></ul>
        </div>

        <div class="span4">
            <h3><?php echo JText::_("COM_SHERING_REFERENCES_ENGINE_SIZES_HEADER"); ?></h3>
            <div class="btn-group">
                <input type="text" id="engine_sizes_input" />
                <i class="icon icon-plus" onclick="javascript:addItem('engine_sizes'); return false;"></i>
            </div>
            <ul id="engine_sizes" style="margin-top: 7px;"></ul>
        </div>

        <script>
            jQuery(document).ready(function () {
                <?php
                    foreach ($this->marks as $mark) {
                        echo "addItem('marks', '" . $mark->name . "');";
                    }

                    foreach ($this->models as $model) {
                        echo "addItem('models', '" . $model->name . "');";
                    }

                    foreach ($this->engine_sizes as $engine_size) {
                        echo "addItem('engine_sizes', '" . $engine_size->name . "');";
                    }
                ?>
            });
        </script>

    </div>

    <?php echo JHtml::_("form.token"); ?>
