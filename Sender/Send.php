<?php
require_once 'Email_sender.php';

class Send {

    private $e_mail_sender;
    private $email_addressee;
    private $name_sender;
    private $link_survey;
    private $name_survey;


    function __construct()
    {
        $this -> e_mail_sender = "shapovalovei@gmail.com";
        $this -> email_addressee = "eshapovalov@readdle.com";
        $this -> name_sender = "Eugene Shapovalov";
        $this -> link_survey = "https://vk.com/shapovaloveugene";
        $this -> name_survey = "What are do you think about your country?";
    }

    /**
     * @return mixed
     */
    public function getEMailSender()
    {
        return $this->e_mail_sender;
    }

    /**
     * @param mixed $e_mail_sender
     */
    public function setEMailSender($e_mail_sender)
    {
        $this->e_mail_sender = $e_mail_sender;
    }

    /**
     * @return mixed
     */
    public function getEmailAddressee()
    {
        return $this->email_addressee;
    }

    /**
     * @param mixed $email_addressee
     */
    public function setEmailAddressee($email_addressee)
    {
        $this->email_addressee = $email_addressee;
    }

    /**
     * @return mixed
     */
    public function getNameSender()
    {
        return $this->name_sender;
    }

    /**
     * @param mixed $name_sender
     */
    public function setNameSender($name_sender)
    {
        $this->name_sender = $name_sender;
    }

    /**
     * @return mixed
     */
    public function getLinkSurvey()
    {
        return $this->link_survey;
    }

    /**
     * @param mixed $link_survey
     */
    public function setLinkSurvey($link_survey)
    {
        $this->link_survey = $link_survey;
    }

    /**
     * @return mixed
     */
    public function getNameSurvey()
    {
        return $this->name_survey;
    }

    /**
     * @param mixed $name_survey
     */
    public function setNameSurvey($name_survey)
    {
        $this->name_survey = $name_survey;
    }

}

$arr;

for($i = 0; $i<3; $i++){

    $send = array("email_sender" => "shapovalovei@gmail.com",
                  "email_addressee" => "eshapovalov@readdle.com",
                  "name_sender" => "Eugene Shapovalov",
                  "link_survey" => "https://vk.com/shapovaloveugene",
                  "name_survey" => "What are do you think about your country?"
    );

    // $send = new Send();
    $arr[$i] = $send;
}



$email_sender = new email_sender;
$email_sender->send_email($arr);


?>