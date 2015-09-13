<!--//<h1 mc:edit="company">company</h1>
//Hello, <div mc:edit="user_name">user_name</div>-->

<?php
require_once 'mandrill-api-php/src/Mandrill.php';
require_once 'Send.php';

class email_sender
{
    /**
     * @param $array_send_data
     * @throws Exception
     * @throws Mandrill_Error
     */
    function send_email($array_send_data)
    {
        foreach ($array_send_data as &$send) {
            try {
                $mandrill = new Mandrill('7OUSQns8FOfo6ge2vgxguw');
                $template_name = 'ua_web_challange_team';
                $template_content = array(
                    array(
                        'name' => 'email_sender',
                        'content' => $send->getEMailSender()
                    ),
                    array(
                        'name' => 'name_sender',
                        'content' => $send->getNameSender()
                    ),
                    array(
                        'name' => 'from_name_sender',
                        'content' => "From: " . $send->getNameSender()
                    ),
                    array(
                        'name' => 'link_survey',
                        'content' => $send->getLinkSurvey()
                    ),
                    array(
                        'name' => 'name_survey',
                        'content' => $send->getNameSurvey()
                    ),
                    array(
                        'name' => 'invitation',
                        'content' => $send->getNameSurvey() . " has sent you survey: "
                    )
                );
                $message = array(
                    'html' => '',
                    'text' => '',
                    'subject' => 'Please go to survey',
                    'from_email' => $send->getEMailSender(),
                    'from_name' => 'Newly Paranoid Maintainers',
                    'to' => array(
                        array(
                            'email' => $send->getEmailAddressee(),
                            'name' => '',
                            'type' => 'to'
                        )
                    ),
                    'headers' => array('Reply-To' => $send->getEMailSender()),
                    'important' => false,
                    'track_opens' => null,
                    'track_clicks' => null,
                    'auto_text' => null,
                    'auto_html' => null,
                    'inline_css' => null,
                    'url_strip_qs' => null,
                    'preserve_recipients' => null,
                    'view_content_link' => null,
                    'bcc_address' => 'message.bcc_address@example.com',
                    'tracking_domain' => null,
                    'signing_domain' => null,
                    'return_path_domain' => null,
                    'merge' => true,
                    'merge_language' => 'mailchimp',
                    'global_merge_vars' => array(
                        array(
                            'name' => 'merge1',
                            'content' => 'merge1 content'
                        ),
                        array(
                            'name' => 'link_survey',
                            'content' => $send->getLinkSurvey()
                        ),
                        array(
                            'name' => 'email_sender',
                            'content' => "mailto:" . $send->getEMailSender()
                        )
                    ),
                    'merge_vars' => array(
                        array(
                            'rcpt' => 'recipient.email@example.com',
                            'vars' => array(
                                array(
                                    'name' => 'merge2',
                                    'content' => 'merge2 content'
                                )
                            )
                        )
                    )
                );
                $async = false;
                $ip_pool = 'Main Pool';
                $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool);
                print_r($result);

            } catch (Mandrill_Error $e) {
                echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
                throw $e;
            }
        }
    }
}

?>