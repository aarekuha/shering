<?php
defined('_JEXEC') or die;

$controller = JControllerLegacy::getInstance('Shering');
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

$controller->redirect();
?>