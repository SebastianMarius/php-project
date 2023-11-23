<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';


class MailFactory
{
    private $mailer;

    public function __construct()
    {

        // Enable verbose debug output
        $this->mailer->SMTPDebug = 0;

        // Set the mailer to use SMTP


        // Specify SMTP server details
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = 'e62bf1cd173d11';
        $phpmailer->Password = '20c2f944c7048a';

        // Set the 'from' address and name
        $this->mailer->setFrom('from@example.com', 'Your Name');
    }

    public function sendMail($to, $subject, $body)
    {
        try {
            // Add a recipient
            $this->mailer->addAddress($to);

            // Set email format to HTML
            $this->mailer->isHTML(true);

            // Set email subject and body
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            // Send the email
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }
    }
}

// Example usage:
$mailFactory = new MailFactory();

$to = 'sebastianmarius2100@gmail.com';
$subject = 'Test Email';
$body = '<p>This is a test email.</p>';

$result = $mailFactory->sendMail($to, $subject, $body);

if ($result === true) {
    echo 'Email sent successfully';
} else {
    echo 'Error: ' . $result;
}