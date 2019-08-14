<?php

defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

class JFormFieldSheringimage extends JFormFieldList {


    protected $type = 'Sheringimage';

    protected function getInput() {

        // parent::getInput();

        JFactory::getDocument()->addScript(JUri::base() . "components/com_shering/js/sheringimage.js");
        JFactory::getDocument()->addStyleSheet(JUri::base() . "components/com_shering/css/sheringimage.css");
        $suffix = JFactory::getApplication()->input->get("id") . "_". $this->getAttribute("suffix");
        $imageSrc = empty($this->value) ? "" : " value='" . $this->value . "'";

        $div = '<div class="row">
                    <div class="span3">
                        <form   class="upload-container" 
                                method="POST" 
                                suffix="' . $suffix . '" 
                                action="'. JRoute::_("index.php?option=com_shering&task=car.addImage&" . JSession::getFormToken() . "=1&suffix=" . $suffix) . '">
                            <div class="text-center">
                                <input id="file-input' . $suffix . '" class="file-input" type="file" name="file" accept="image/*;capture=camera">
                                <label for="file-input' . $suffix . '">Выберите файл</label><br />
                                <span>или перетащите его сюда</span>
                            </div>
                            <img style="height: 200px; position: absolute; margin: auto;" src="" id="form' . substr($suffix, -1) . 'Image" />
                            <script>
                                var imgSrc = jQuery("#jform_images_' . $this->getAttribute("imgFrom") . '").val();
                                if (imgSrc) {
                                    jQuery("#form' . substr($suffix, -1) . 'Image").attr("src", "/images/cars/" + imgSrc);
                                }
                            </script>
                        </form>
                    </div>
                </div>';

        return $div;
    }
}
