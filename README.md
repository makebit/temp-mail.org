# Temp-Mail.org

Get and use a free disposable temporary mail directly in your PHP code using the temp-mail.org service API.


## USAGE
```
// Generate a random temp email
$tempMail = new TempMail();
```

```
// Use the mail passed as parameter
$tempMail = new TempMail("test@maileme101.com");
```

```
// Get all the mails (from the newest to the oldest) as an array
$tempMail->getMails();
```

```
// Get a limited number of mails the mails as an array
$tempMail->getMails(10);
```

```
// Get the last mail
$tempMail->getLastMail();
```

```
// Delete a mail
$tempMail->deleteMail($mail)
```

```
// Print all the mails with some formatting
$tempMail->echoMails($tempMail->getMails());
```

```
// Print the last mail with some formatting
$tempMail->echoMail($tempMail->getLastMail());
```

## API

[https://temp-mail.org/api](https://temp-mail.org/api)