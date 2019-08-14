<?php
defined('_JEXEC') or die;

class TestingModelTicket extends JModelItem
{
    protected function populateState()
    {
        $app = JFactory::getApplication();
        $id = $app->input->getInt("id");
        $this->setState("ticket.id", $id);

        parent::populateState();
    }

    public function getItem($pk = null)
    {
        $pk = (!empty($pk)) ? $pk : $this->getState("ticket.id");

        if (!$pk)
            return false;

        $query = $this->getDbo()->getQuery(true);
        $query->select("a.id as question_id, a.question, a.answers, a.type");
        $query->from("#__test_questions as a");

        $query->join("left", "#__test_documents as b on (b.id = a.document_id)");
        $query->join("left", "#__test_tickets as c on (c.id = b.ticket_id)");

        $query->select("d.id as user_ticket_id");
        $query->join("left", "#__test_users_tickets as d on (c.id = d.ticket_id)");

        $query->where("d.id = " . $query->escape($pk));

        $db = JFactory::getDbo();
        $db->setQuery($query);

        $items = $db->loadObjectList();

        foreach ($items as $item) {
            $item->answers = json_decode($item->answers);
        }

        return $items;
    }

    public function submitTicket($user_ticket_id, $ticket_form) {
        $user_ticket = new stdClass();
        $user_ticket->user_ticket_id = $user_ticket_id;

        foreach($ticket_form as $question_id => $ticket_field) {
            $user_ticket->question_id = $question_id;
            if (is_array($ticket_field)) {
                $ticket_field = implode(";<br />", $ticket_field);
            }
            $user_ticket->answer = $ticket_field;

            if (!JFactory::getDbo()->insertObject('#__test_users_answers', $user_ticket))
                return false;
        }

        $user_ticket = new stdClass();
        $user_ticket->id = $user_ticket_id;
        $user_ticket->status = 1;

        return JFactory::getDbo()->updateObject('#__test_users_tickets', $user_ticket, 'id');
    }
}

?>