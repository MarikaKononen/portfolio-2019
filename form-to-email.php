<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	header('Location: error-message.html');
}
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$message = $_POST['message'];

//Validate first
if(empty($name)||empty($visitor_email)) 
{
    echo "Nimi ja sähköposti on pakollisia!";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Tarkasta sähköpostiosoite!";
    exit;
}

$email_from = 'marika.kononen@cfml.fi';//<== my email address
$email_subject = "Yhteydenottolomakkeelta viesti portfolisivulta";
$email_body = "Olet saanut viestin porfoliosivulta henkilöltä $name.\n".
    "Viesti :\n $message ".
    
$to = "marika.kononen@cfml.fi";//<== my email address
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: thank-you.html');


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
   
?> 