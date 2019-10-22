<?php
defined('_JEXEC') or die;

require_once JPATH_COMPONENT_SITE . "/models/criteria.php";

class SheringModelUser extends JModelItem
{
    public function getItem($pk = null)
    {
        $token = JFactory::getApplication()->getUserState("shering_token");

        if (strlen($token) != 10) {
            return false;
        }

        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $query->select("fio, tel, smscounter, status, registration_date");
        $query->from("#__shering_users");
        $query->where("`token` = " . $query->quote($query->escape($token)));

        $db = JFactory::getDbo();
        $db->setQuery($query);

        return $db->loadObject();
    }

    protected static function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function getToken()
    {
        $input = JFactory::getApplication()->input;
        $tel = substr($input->get("shering_tel"), -10);
        $password = $input->get("shering_password");

        $token = SheringModelUser::generateRandomString(10);

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // Fields to update.
        $fields = array(
            $db->quoteName('token') . ' = ' . $db->quote($token)
        );

        // Conditions for which records should be updated.
        $conditions = array(
            $db->quoteName('tel') . ' = ' . $query->quote($query->escape($tel)),
            $db->quoteName('password') . ' = ' . $query->quote($query->escape($password))
        );

        $query->update($db->quoteName('#__shering_users'))->set($fields)->where($conditions);
        $db->setQuery($query);
        $db->execute();
        if ($db->getAffectedRows()) {
            JFactory::getApplication()->setUserState("shering_token", $token);
            return true;
        }

        JFactory::getApplication()->setUserState("shering_token", "");
        return false;
    }

    public function logoff()
    {
        $app = JFactory::getApplication();

        $token = $app->getUserState("shering_token", "");
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // Fields to update.
        $fields = array(
            $db->quoteName('token') . ' = null'
        );

        // Conditions for which records should be updated.
        $conditions = array(
            $db->quoteName('token') . ' = ' . $db->quote($token)
        );

        $query->update($db->quoteName('#__shering_users'))->set($fields)->where($conditions);
        $db->setQuery($query);
        $db->execute();

        $app->setUserState("shering_token", "");
    }

    public static function sendSms($tel, $text) {
        $tel = substr($tel, -10);
        require_once JPATH_COMPONENT_SITE . '/sms/sms.ru.php';
        $params = JComponentHelper::getParams('com_shering');
        $debugSms = $params->get('debugSms');
        if ($debugSms) {
            $text = "Получатель СМС: " . $tel . "\n" .
                    "Текст СМС: " . $text;

            echo json_encode(array('success' => 1, 'reciever' => $tel, 'message' => $text));

            return;
        }

        $smsApiKey = $params->get('smsApiKey');
        $smsru = new SMSRU($smsApiKey); // Ваш уникальный программный ключ, который можно получить на главной странице

        $data = new stdClass();
        $data->to = (string)$tel;
        $data->text = (string)$text; // Текст сообщения
        // $data->from = ''; // Если у вас уже одобрен буквенный отправитель, его можно указать здесь, в противном случае будет использоваться ваш отправитель по умолчанию
        // $data->translit = 1; // Перевести все русские символы в латиницу (позволяет сэкономить на длине СМС)
        $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную
    }

    public function sendRememberSms($tel)
    {
        $next_sms = JFactory::getApplication()->getUserState("shering_next_sms", 0);
        if ($next_sms > time()) {
            return;
        }
        $pin = rand(1000, 9999);
        JFactory::getApplication()->setUserState("shering_pin", $pin);
        JFactory::getApplication()->setUserState("shering_next_sms", strtotime("+1 minutes"));

        $params = JComponentHelper::getParams('com_shering');
        $smsPrefix = $params->get('textRemmemberSms');
        SheringModelUser::sendSms($tel, $smsPrefix . $pin);
    }

    public static function isNewUser($tel) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("id")->from("#__shering_users")->where("tel = " . $db->quote($tel));
        $db->setQuery($query);
        $result = $db->loadResult();
        return empty($result);
    }

    public function sendPassword($tel)
    {
        $tel = substr($tel, -10);
        $new_password = rand(1000, 9999);
        $newUser = new stdClass();
        $newUser->tel = $tel;
        $newUser->password = $new_password;

        $params = JComponentHelper::getParams('com_shering');
        $smsPrefix = $params->get('textPasswordSms');
        SheringModelUser::sendSms($tel, $smsPrefix . $new_password);
        
        if (SheringModelUser::isNewUser($tel)) {
            $newUser->fio = "";
            $newUser->smscounter = 0;
            $newUser->status = 0;
            $newUser->registration_date = date('Y-m-d');
            JFactory::getDbo()->insertObject('#__shering_users', $newUser);
            
            $textNewUserAlert = $params->get('textNewUserAlert');
            $masterTel = preg_replace("/(\+7|\s)/i", "", $params->get('contacttelephone'));
            SheringModelUser::sendSms($masterTel, $textNewUserAlert . ": +7" . $tel);
        } else {
            JFactory::getDbo()->updateObject('#__shering_users', $newUser, 'tel');
        }

        
    }

    public function update()
    {
        $app = JFactory::getApplication();
        $input = $app->input;
        $token = $app->getUserState("shering_token");
        if (empty($token)) {
            $app->redirect(JRoute::_("index.php"));
            return;
        }
        $fio = $input->getString("fio");
        $password = $input->getString("password");

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("id, fio, status")->from("#__shering_users")->where("`token` = " . $db->quote($token));
        $db->setQuery($query);
        $result = $db->loadObject();
        $dbFio = $result->fio;
        $dbStatus = $result->status;
        $id = $result->id;

        $object = new stdClass();

        $object->id = $id;
        if ($dbFio != $fio) {
            $object->fio = $fio;
            if ($dbStatus == 1) {
                $object->status = 0;
            }
        }

        if ((strlen($password) > 3) && (strlen($password) < 15)) {
            $object->password = $password;
        }

        JFactory::getDbo()->updateObject("#__shering_users", $object, "id");
        $app->redirect(JRoute::_("index.php?option=com_shering&view=user"));
    }

    public function getCriteries()
    {
        $token = JFactory::getApplication()->getUserState("shering_token");
        $user_id = SheringModelCriteria::getUserId($token);

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("a.id, a.class, a.year, a.engine_type, a.transmission, a.interior, a.conditioner, a.creation_date, a.cost");
        $query->from("#__shering_criteria as a");

        $query->select("b.name as mark");
        $query->join("left", "#__shering_marks as b on b.id = a.mark");

        $query->select("c.name as model");
        $query->join("left", "#__shering_models as c on c.id = a.model");

        $query->select("d.name as engine_size");
        $query->join("left", "#__shering_engine_sizes as d on d.id = a.engine_size");
        
        $query->select("e.car_number");
        $query->join("left", "#__shering_cars as e on e.id = a.car_id");

        $query->where("`user_id` = " . $user_id);
        $query->where("`deleted` !=  1");
        $db->setQuery($query);

        return $db->loadObjectList();
    }

    public function getUserStatus()
    {
        $tel = JFactory::getApplication()->input->get("shering_tel");
        if (empty($tel)) {
            return;
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("status")->from("#__shering_users")->where("tel = " . $db->quote($tel));
        $db->setQuery($query);
        $status = $db->loadResult();
        return ($status == 2) ? "blocked" : "";
    }
    
    public function reserve($carId)
    {
        if (empty($carId)) {
            return;
        }
        
        $criteries = $this->getCriteries();
        if (count($criteries) > 2) {
            return; 
        }
        
        $token = JFactory::getApplication()->getUserState("shering_token");
        $user_id = SheringModelCriteria::getUserId($token);
        
        if (empty($user_id)) {
            return;
        }
        
        $db = JFactory::getDbo();
        
        $criteria = new stdClass();
        $criteria->car_id = (int)$carId;
        $criteria->user_id = $user_id;
        $criteria->creation_date = date('Y-m-d');
        
        $query = $db->getQuery(true);
        $query->select('COUNT(*)')
              ->from($db->quoteName('#__shering_criteria'))
              ->where($db->quoteName('car_id') . " = " . $db->quote($criteria->car_id))
              ->where($db->quoteName('user_id') . " = " . $db->quote($criteria->user_id));
        $db->setQuery($query);
        $count = $db->loadResult(); 
        
        if ($count) {
            return;
        }
        
        JFactory::getDbo()->insertObject('#__shering_criteria', $criteria);
    }
}