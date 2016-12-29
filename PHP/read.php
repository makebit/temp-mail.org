<?php
include_once("temp-mail.php");

$mail = $_GET['mail'];

$tempMail = new TempMail($mail);
echo '<hr>Email: ' . $tempMail->mail;

$tempMail->echoMails($tempMail->getMails());