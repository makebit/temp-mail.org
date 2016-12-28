<?php
include_once("temp-mail.php");

// Generate a random temp email
$tempMail1 = new TempMail();
echo '<hr>New email: ' . $tempMail1->mail;
var_dump($tempMail1->getMails());


// Use the mail passed as parameter
$tempMail2 = new TempMail("test@maileme101.com");
echo '<hr>Email: ' . $tempMail2->mail;

$tempMail2->echoMails($tempMail2->getMails());
$tempMail2->echoMails($tempMail2->getMails(10));
$tempMail2->echoMail($tempMail2->getLastMail());


$mail = $tempMail2->getLastMail();
//echo "<br>Deleting: " . $mail[0]->mail_id . ' ' . $tempMail2->deleteMail($mail)->result;

