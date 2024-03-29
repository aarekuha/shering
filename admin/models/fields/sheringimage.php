<?php

defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

class JFormFieldSheringimage extends JFormFieldList {
    protected $type = 'Sheringimage';

    protected function getInput() {
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
}
