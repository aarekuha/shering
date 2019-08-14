<?php
defined('_JEXEC') or die;

class TestingControllerTicket extends JControllerForm {

    public function getModel($name = 'Ticket', $prefix = 'TestingModel', $config = array())
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function submit() {
        JSession::checkToken("post") or die();

        $ticket_form = $_POST['ticket_form'];
        $user_ticket_id = $_POST['user_ticket_id'];

        if(empty($ticket_form) || empty($user_ticket_id)) {
            return false;
        }

        $model = $this->getModel();

        $app = JFactory::getApplication();

        if ($model->submitTicket($user_ticket_id, $ticket_form)) {
            $message = JText::_("COM_TESTING_SUCCESS_FORM_SUBMIT");
            $type = "success";
        } else {
            $message = JText::_("COM_TESTING_FAIL_FORM_SUBMIT");
            $type = "error";
        }
        $app->enqueueMessage($message, $type);
        $app->redirect(JRoute::_('index.php?option=' . $this->option . "&view=tickets"));
    }
}