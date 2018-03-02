<?php
$contact_email_to = "sara_hgashti@hotmail.com";

$contact_error_firstname = "First Name is too short or empty!";
$contact_error_lastname = "Last Name is too short or empty!";
$contact_error_middlename = "Middle Name is too short or empty!";
$contact_error_email = "Please enter a valid email!";
$contact_error_sin = "Please enter 4 last digit number of SIN";


if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
  die('Sorry Request must be Ajax POST');
}

if(isset($_POST)) {

  $firstname = filter_var($_POST["firstname"], FILTER_SANITIZE_STRING);
  $middlename = filter_var($_POST["middelname"], FILTER_SANITIZE_EMAIL);
  $lastname = filter_var($_POST["lastname"], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
  $sin = filter_var($_POST["sin"], FILTER_SANITIZE_STRING);
  $datebirth = filter_var($_POST["dateBirth"], FILTER_SANITIZE_STRING);

  if(strlen($firstname)<3 ){
    die($contact_error_firstname);
  }


  if(strlen($lastname)<3 or strlen($lastname)>10){
    die($contact_error_lastname);
  }
  
  if(strlen($sin)!=4){
    die($contact_error_sin);
  }  

  if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    die($contact_error_email);
  }



  if(!isset($contact_email_from)) {
    $contact_email_from = "contactform@" . @preg_replace('/^www\./','', $_SERVER['SERVER_NAME']);
  }

  $sendemail = mail($contact_email_to, $contact_subject_prefix . $datebirth, $sin,
    "From:  $firstname.' '.$lastname <$contact_email_from>" . PHP_EOL .
    "Reply-To: $email" . PHP_EOL .
    "X-Mailer: PHP/" . phpversion()
  );

  if( $sendemail ) {
    echo 'OK';
  } else {
    echo 'Could not send mail! Please check your PHP mail configuration.';
  }
}
?>
