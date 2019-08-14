<?php
defined("_JEXEC") or die();

abstract class SheringHelper {
    public static function addSubMenu($viewName)
    {
        JHtmlSidebar::addEntry(JText::_("COM_SHERING_MENU_CARS"),
            'index.php?option=com_shering&view=cars',
            $viewName == 'cars');

        JHtmlSidebar::addEntry(JText::_("COM_SHERING_MENU_USERS"),
            'index.php?option=com_shering&view=users',
            $viewName == 'users');

        JHtmlSidebar::addEntry(JText::_("COM_SHERING_MENU_REFERENCES"),
            'index.php?option=com_shering&view=references',
            $viewName == 'references');

        JHtmlSidebar::addEntry(JText::_("COM_SHERING_MENU_CRITERIES"),
            'index.php?option=com_shering&view=criteries',
            $viewName == 'criteries');

        return JHtmlSidebar::render();
    }
}

?>
