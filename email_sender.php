<!--//<h1 mc:edit="company">company</h1>
//Hello, <div mc:edit="user_name">user_name</div>-->

<?php
require_once 'mandrill-api-php/src/Mandrill.php';

$email_sender = "shapovalovei@gmail.com";
$email_addressee = "eshapovalov@readdle.com";
$name_sender = "Eugene Shapovalov";
$link_survey = "https://vk.com/shapovaloveugene";
$name_survey = "What are do you think about your country?";

try {
    $mandrill = new Mandrill('7OUSQns8FOfo6ge2vgxguw');
    $template_name = 'ua_web_challange_team';
    $template_content = array(
        array(
            'name' => 'email_sender',
            'content' => $email_sender
        ),

        array(
            'name' => 'name_sender',
            'content' => $name_sender
        ),
        array(
            'name' => 'from_name_sender',
            'content' => "From: " . $name_sender
        ),
        array(
            'name' => 'link_survey',
            'content' => $link_survey
        ),
        array(
            'name' => 'name_survey',
            'content' => $name_survey
        ),
        array(
            'name' => 'invitation',
            'content' => $name_sender . " has sent you survey: "
        )
    );
    $message = array(
        'html' => '<p>Example HTML content</p>',
        'text' => 'Example text content',
        'subject' => 'Test e-mail subject',
        'from_email' => 'shapovalovei@gmail.com',
        'from_name' => 'Example Name',
        'to' => array(
            array(
                'email' => $email_addressee,
                'name' => 'Viktor Maksimenko',
                'type' => 'to'
            )
        ),
        'headers' => array('Reply-To' => $email_sender),
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
                 'content' => $link_survey
             ),
            array(
                 'name' => 'email_sender',
                 'content' => "mailto:".$email_sender
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
    $send_at = 'example send_at';
    $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool);
    print_r($result);

} catch(Mandrill_Error $e) {
    // Mandrill errors are thrown as exceptions
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
    // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
    throw $e;
}
?>