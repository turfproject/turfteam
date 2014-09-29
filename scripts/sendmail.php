<?php
if($_POST)
{
    $to_email       = "andrewfulton59@gmail.com"; //Recipient email, Replace with own email here
   
    //check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
       
        $output = json_encode(array( //create JSON data
            'type'=>'error',
            'text' => 'Sorry Request must be Ajax POST'
        ));
        die($output); //exit script outputting json data
    }
   
    //Sanitize input data using PHP filter_var().
    $first_name      = filter_var($_POST["first_name"], FILTER_SANITIZE_STRING);
	$last_name      = filter_var($_POST["last_name"], FILTER_SANITIZE_STRING);
    $email     = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
	$address_one      = filter_var($_POST["address_one"], FILTER_SANITIZE_STRING);
	$address_two      = filter_var($_POST["address_two"], FILTER_SANITIZE_STRING);
	$city   = filter_var($_POST["city"], FILTER_SANITIZE_STRING);
    $post_code   = filter_var($_POST["post_code"], FILTER_SANITIZE_STRING);
    $phone_number   = filter_var($_POST["phone_number"], FILTER_SANITIZE_NUMBER_INT);
	$item_name   = filter_var($_POST["item_name"], FILTER_SANITIZE_STRING);
   
    //additional php validation
    if(strlen($first_name)<2){ // If length is less than 4 it will output JSON error.
        $output = json_encode(array('type'=>'error', 'text' => 'Name is too short or empty!'));
        die($output);
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //email validation
        $output = json_encode(array('type'=>'error', 'text' => 'Please enter a valid email!'));
        die($output);
    }
    if(!filter_var($phone_number, FILTER_SANITIZE_NUMBER_FLOAT)){ //check for valid numbers in phone number field
        $output = json_encode(array('type'=>'error', 'text' => 'Enter your phone number'));
        die($output);
    }
        if(strlen($address_one)<1){ //check for valid numbers in phone number field
        $output = json_encode(array('type'=>'error', 'text' => 'Enter your address'));
        die($output);
    }
            if(strlen($post_code)<3){ //check for valid numbers in phone number field
        $output = json_encode(array('type'=>'error', 'text' => 'Enter a valid post code'));
        die($output);
    }
   
    //email body
    $message_body = "\r\nFirst Name: ".$first_name."\r\nLast Name: ".$last_name."\r\nEmail : ".$email."\r\nPhone Number: ".$phone_number."\r\nAddress: ".$address_one.",".$address_two."\r\nCity: ".$city."\r\nPost Code: ".$post_code."\r\nItem: ".$item_name;
   
    $subject ="New Order";
    //proceed with PHP email.
    $headers = 'From: '.$first_name.'' . "\r\n" .
    'Reply-To: '.$user_email.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
   
    $send_mail = mail($to_email, $subject, $message_body, $headers);
   
    if(!$send_mail)
    {
        //If mail couldn't be sent output error. Check your PHP email configuration (if it ever happens)
        $output = json_encode(array('type'=>'error', 'text' => 'Could not send mail! Please check your PHP mail configuration.'));
        die($output);
    }else{
        $output = json_encode(array('type'=>'message', 'text' => 'Hi '.$first_name .' Thank you for your order'));
        die($output);
    }
}
?>