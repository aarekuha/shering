<?php
defined('_JEXEC') or die;

require_once JPATH_COMPONENT_SITE . "/models/criteria.php";

class SheringViewUser extends JViewLegacy
{
    protected $item;
    protected $state;
    protected $token;
    protected $criteries;

    protected $incorrect_login = false;
    protected $incorrect_pin = false;
    protected $userIsBlocked = false;
    protected $smsSended = false;

    protected $license1 = "";
    protected $license2 = "";

    public function getRecaptchaText() {
        $params = JComponentHelper::getParams('com_shering');
        $googleReCaptchaKey = $params->get('googleReCaptchaKey');

        $googleReCaptchaEnabled = $params->get('googleReCaptchaEnabled');
        if ($googleReCaptchaEnabled == false) {
            return "";
        }

        $header = '<script src="https://www.google.com/recaptcha/api.js?render=' . $googleReCaptchaKey . '"></script>';
        $body = "<input type='hidden' name='recaptchaKey' id='recaptchaKey' value=''>
                 <script>
                    grecaptcha.ready(function() {
                        grecaptcha.execute('" . $googleReCaptchaKey . "', {action: 'login'}).then(function(token) {
                           $('#recaptchaKey').val(token);
                        });
                    });
                 </script>";

        return $header . $body;
    }

    private function getRecaptchaFromGoogle($recaptchaKey) {
        $params = JComponentHelper::getParams('com_shering');

        $googleReCaptchaSecretKey = $params->get('googleReCaptchaSecretKey');
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $googleReCaptchaSecretKey .
                                                    '&response=' . $recaptchaKey);
        return json_decode($response);
    }

    public function checkGoogleRecaptcha() {
        $params = JComponentHelper::getParams('com_shering');
        $googleReCaptchaEnabled = $params->get('googleReCaptchaEnabled');
        if ($googleReCaptchaEnabled == false) {
            return;
        }

        $googleResponce = $this->getRecaptchaFromGoogle(JFactory::getApplication()->input->get("recaptchaKey"));
        if ($googleResponce->success != '1') {
            $this->recaptchaError();
        }
    }

    public function display($tpl = "login")
    {
        if ($this->get("UserStatus") == "blocked") {
            $this->userIsBlocked = true;
            return parent::display($tpl);
        }

        $this->state = $this->get("State");
        $this->token = JFactory::getApplication()->getUserState("shering_token");
        $input = JFactory::getApplication()->input;
        $model = $this->getModel();
        $tel = substr($input->get("shering_tel"), -10);

        if ($this->token) {

            $tpl = "user";

        } else if ($this->state->get("task") == "remember") {

            $tpl = "remember";

        } else if ($this->state->get("task") == "confirm") {

            $this->checkGoogleRecaptcha();
            $model->sendRememberSms($tel);
            $tpl = "confirm";

        } else if ($this->state->get("task") == "checkConfirm") {

            $this->checkGoogleRecaptcha();
            if ($input->get("shering_pin") != JFactory::getApplication()->getUserState("shering_pin")) {
                $tpl = "confirm";
                $this->incorrect_pin = true;
            } else {
                $tpl = "login";
                $model->sendPassword($tel);
                $this->smsSended = true;
            }

        } else if ($this->state->get("task") == "login") {

            $password = $input->get("shering_password");
            if ((strlen($tel) == 10) && (!empty($password))) {
                $this->token  = $this->get("Token");
                if ($this->token) {
                    $tpl = "user";
                } else {
                    $tpl = "login";
                    $this->incorrect_login = true;
                }
            }
        }

        if ($tpl == "user") {
            $this->item = $this->get("Item");
            if (empty($this->item)) {
                $this->checkGoogleRecaptcha();
                $tpl = "login";
                $this->incorrect_login = true;
                JFactory::getApplication()->setUserState("shering_token", "");
            } else {
                $model->reserve(JFactory::getApplication()->input->get("reserve"));
                $this->criteries = $this->get("Criteries");
                        
                $id = SheringModelCriteria::getUserId($this->token);
                $filepath = JPATH_COMPONENT_ADMINISTRATOR . "/images/licenses/" . $id;
                if (file_exists($filepath . "_1" . ".png")) {
                    $this->license1 = JUri::base() . "administrator/components/com_shering/images/licenses/" . $id . "_1.png";
                }
                if (file_exists($filepath . "_2" . ".png")) {
                    $this->license2 = JUri::base() . "administrator/components/com_shering/images/licenses/" . $id . "_2.png";
                }
            }
        }

        parent::display($tpl);
    }

    private function recaptchaError() {
        die("Ошибка проверки системы защиты Google reCaptcha! Попробуйте войти позже.");
    }
}