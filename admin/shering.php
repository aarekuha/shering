<?php
defined("_JEXEC") or die();

$controller = JControllerLegacy::getInstance("Shering");
JLoader::register("SheringHelper", __DIR__."/helpers/shering.php");
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd("task", "display"));
$controller->redirect();

?>