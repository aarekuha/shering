<?php

defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('radio');

class JFormFieldSheringcolor extends JFormFieldRadio {
    protected $type = 'Sheringcolor';

    protected function getInput() {
        $div = '<div class="">';
        $div .= '<style>
                    .dot {
                        height: 25px;
                        width: 25px;
                        margin: 3px;
                        border-radius: 50%;
                        display: inline-block;
                        border: 1px solid gray;
                    }
                    .dot active {
                        box-shadow: 0px 0px 10px 10px black;
                    }
                </style>';
        $div .= '<script>
                    let previousColorItem = "";
                    function dotSet(colorId, sender) {
                        jQuery("#color").val(colorId);
                        jQuery(sender).css("box-shadow", "0px 0px 5px 2px #333");
                        jQuery(sender).css("border", "2px double white");
                        if (previousColorItem) {
                            jQuery(previousColorItem).css("box-shadow", "");
                            jQuery(previousColorItem).css("border", "1px solid gray");
                        }
                        previousColorItem = sender;
                    }
                </script>';
        $options = $this->getOptions();
        $div .= '<div class="span12">';
        $div .= '<input type="hidden" name="jform[color]" id="color" value="">';
        foreach ($options as $option) {
            $div .= '<span class="dot" id="dot' . $option->id . '" style="background-color: #' . $option->value . ';" onclick="javascript:dotSet(' . $option->id . ', this);"> </span>';
        }
        $div .= '</div></div>';   
        $div .= '<script> 
                    dotSet(' . $this->value . ', document.getElementById("dot' . $this->value . '")); 
                </script>';
        return $div;
        
        JFactory::getDocument()->addScript(JUri::base() . "components/com_shering/js/sheringimage.js");
        JFactory::getDocument()->addStyleSheet(JUri::base() . "components/com_shering/css/sheringimage.css");
        $suffix = JFactory::getApplication()->input->get("id") . "_". $this->getAttribute("suffix");
        $imageSrc = empty($this->value) ? "" : " value='" . $this->value . "'";

        $div = '<div class="row">
                    <div class="span3">
                        <form   id="form-input' . $suffix . '"
                                class="upload-container" 
                                method="POST" 
                                suffix="' . $suffix . '" 
                                action="'. JRoute::_("index.php?option=com_shering&task=car.addImage&" . JSession::getFormToken() . "=1&suffix=" . $suffix) . '">
                            <img style="height: 160px; border-radius: 10px; z-index: 99; position: absolute; margin: auto;" src="" id="form' . substr($suffix, -1) . 'Image" />
                            <div class="text-center">
                                <input id="file-input' . $suffix . '" class="file-input" type="file" name="file" accept="image/*;capture=camera">
                                <label>Выберите файл</label><br />
                                <span>или перетащите его сюда</span>
                            </div>
                            <script>
                                var imgSrc = jQuery("#jform_images_' . $this->getAttribute("imgFrom") . '").val();
                                if (imgSrc) {
                                    jQuery("#form' . substr($suffix, -1) . 'Image").attr("src", "/images/cars/" + imgSrc);
                                }
                                jQuery("#form-input' . $suffix . '").on("click", function () { 
                                    document.getElementById("file-input' . $suffix . '").click();
                                    return true;
                                });
                            </script>
                        </form>
                    </div>
                </div>';

        return $div;
    }
    
    protected function getOptions() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("id, name, value");
        $query->from("#__shering_colors");
        
        $db->setQuery($query);
        return $db->loadObjectList();
    }
}
