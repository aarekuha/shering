<?php
defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
?>

<style>
    .rounded {
        counter-reset: li;
        list-style: none;
        padding: 0;
    }
    .rounded li {
        position: relative;
        display: block;
        padding: .4em .4em .4em 2em;
        margin: .5em 0;
        text-decoration: none;
        border-radius: .3em;
        transition: .3s ease-out;
        border-top: 1px solid #999999;
    }
    .rounded li:hover:before {transform: rotate(360deg);}
    .rounded li:before {
        content: counter(li);
        counter-increment: li;
        position: absolute;
        left: -1.3em;
        top: 50%;
        margin-top: -1.3em;
        background: #333333;
        color: #ffffff;
        height: 2em;
        width: 2em;
        line-height: 2em;
        border: .3em solid white;
        text-align: center;
        font-weight: bold;
        border-radius: 2em;
        transition: all .3s ease-out;
    }
    .rounded li:hover:before {
        color: #ff0;
    }
    .test_textarea {
        padding: 5px;
        width: 90%;
    }
    .questionText {
        font-weight: bold;
        text-decoration: underline;
        margin-bottom: -10px;
        display: block;
    }
    .questionTextArea input {
        float: left;
    }
</style>
<form class="form-validate" id="formvalidate" action="#" method="post" name="ticket_form">
    <ul class="rounded">
        <?php
            $answerCounter = 0;
            foreach ($this->item as $item) {
                echo "<li>";
                    echo "<div class='control-group'>";
                        echo "<span class='questionText'>" . $item->question . "</span><br />";
                        $answers = "";
                        if ($item->type == 0) { // Свободный ответ
                            $answers = "<textarea name='ticket_form[" . $item->question_id . "]'
                                                  class='required test_textarea' 
                                                  required='true' 
                                                  aria-required='true' 
                                                  placeholder='" . JText::_('COM_TESTING_FREE_ANSWER') . "'></textarea>";
                        }
                        if ($item->type == 1) { // Галочка (Несколько вариантов)
                            $miniCounter = 0;
                            foreach ($item->answers as $answer) {
                                $answers .= "<label class='checkbox'>
                                                <input type='checkbox'
                                                       name='ticket_form[" . $item->question_id . "][" . $miniCounter++ . "]'
                                                       value='" . $answer . "' /> 
                                                       " . $answer . "
                                             </label>";
                            }
                        }
                        if ($item->type == 2) { // Выбор (Один вариант)
                            foreach ($item->answers as $answer) {
                                $answers .= "<label class='checkbox'>
                                                <input type='radio'
                                                       name='ticket_form[" . $item->question_id . "]'
                                                       value='" . $answer . "' /> 
                                                       " . $answer . "
                                             </label>";
                            }
                        }
                        echo "" . $answers . "";
                    echo "</div>";
                echo "</li>";
            }
        ?>

    </ul>
    <div class="span12" style="text-align: right;">
        <button class="validate btn"><?php echo JText::_("COM_TESTING_TICKET_SUBMIT_BUTTON"); ?></button>
    </div>

    <input type="hidden" name="task" value="ticket.submit" />
    <input type="hidden" name="user_ticket_id" value="<?php echo $this->item[0]->user_ticket_id; ?>" />
    <?php echo JHtml::_('form.token'); ?>
</form>
