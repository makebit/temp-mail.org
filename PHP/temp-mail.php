<?php

/**
 * Class TempMail
 *
 * This class uses the APIs of the temp-mail.org service
 * to create mail addresses, read and delete mails.
 * See https://temp-mail.org/api for more details.
 */
class TempMail
{

    public $mail;
    const APIURL = "https://api.temp-mail.org/";
    const APIDOMAINENDPOINT = "request/domains";
    const APIGETSMAILENDPOINT = "request/mail/id";
    const APIDELETEMAILENDPOINT = "request/delete/id";

    /**
     * TempMail constructor.
     * Get a new random mail address or initialize the object with the @param null $mail
     * @return TempMail
     */
    function TempMail($mail = null)
    {
        if (isset($mail)) {
            $this->mail = $mail;
        } else {
            // Generate a new mail
            $this->mail = $this->randomMail();
        }
    }

    /**
     * Generate a random mail
     * @return string
     */
    private function randomMail()
    {
        $domainList = $this->getDomainList();
        $newMail = uniqid() . $domainList[rand(0, count($domainList) - 1)];
        return $newMail;
    }

    /**
     * Get the available domains offered by the service
     * @return mixed
     */
    private function getDomainList()
    {
        return $this->curlGET(self::APIDOMAINENDPOINT);
    }

    /**
     * Make Http requests
     * @param $url
     * @return mixed
     */
    private function curlGET($url)
    {
        $requestURL = self::APIURL . $url . '/format/json/';
        //echo "<br>curl request to: " . $requestURL;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $requestURL);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (!($httpcode >= 200 && $httpcode < 300)) echo "<br><span style='color:#ff0000'>Http response " . $httpcode . '</span>';
        curl_close($ch);

        //echo "<br>curl response: " . $response;
        $data = json_decode($response);
        return $data;
    }

    /**
     * Get the last received mail
     * @return array|mixed
     */
    function getLastMail()
    {
        return $this->getMails(1)[0];
    }

    /**
     * Return the mails for this object.
     * Limit the length of the response with @param null $limit
     * @return array|mixed
     */
    function getMails($limit = null)
    {
        $mails = $this->curlGET(self::APIGETSMAILENDPOINT . '/' . md5($this->mail));
        if(isset($mails)){
            if (isset($mails->error)) {
                echo '<br>Error: ' . $mails->error;
            }else{
                $mails = array_reverse($mails);

                if (isset($limit)) {
                    return array_slice($mails, 0, $limit);
                } else {
                    return $mails;
                }
            }
        }
        return null;
    }

    /**
     * Delete a given email
     * @param $mail
     * @return mixed|void
     */
    function deleteMail($mail)
    {
        if (isset($mail[0]->mail_id))
            $mailId = $mail[0]->mail_id;
        else
            return null;
        return $this->curlGET(self::APIDELETEMAILENDPOINT . '/' . $mailId);
    }

    /**
     * Print the list of mails
     * @param $mails
     */
    function echoMails($mails)
    {
        for ($i = 0; $i < count($mails); $i++) {
            $this->echoMail($mails[$i]);
        }
    }

    /**
     * Print a mail
     * @param $mail
     * @internal param $mails
     * @internal param $i
     */
    public function echoMail($mail)
    {
        if(isset($mail)) {
            echo '<li>Id: ' . $mail->mail_id;
            echo '<li>From: ' . $mail->mail_from;
            echo '<li>Sub: ' . $mail->mail_subject;
            echo '<li>Text: ' . $mail->mail_text;
            echo '<li>TS: ' . $mail->mail_timestamp;
            echo '<br>';
        }
    }


}
