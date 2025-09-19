<?php
require __DIR__ . '/../../vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ==== GMAIL SMTP CONFIG ====
$adminEmail = 'restart4317@gmail.com'; // Where emails are sent
$smtpUser   = 'restart4317@gmail.com'; // Your Gmail address
$smtpPass   = 'vqaq aqch vpzv cmro';    // Gmail App Password
$smtpHost   = 'smtp.gmail.com';
$smtpPort   = 587;
$smtpSecure = PHPMailer::ENCRYPTION_STARTTLS;

// ==== DATABASE CONFIG ====
$dbHost = 'u221253909_restart';
$dbUser = 'u221253909_root';
$dbPass = 'password@123Restart';
$dbName = 'restart';

// ==== SANITIZE INPUT ====
function clean_input($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

$name    = clean_input($_POST['name'] ?? '');
$email   = clean_input($_POST['email'] ?? '');
$phone   = clean_input($_POST['phone'] ?? '');
$message = clean_input($_POST['message'] ?? '');

// ==== VALIDATE ====
if (empty($name) || empty($email) || empty($message)) {
    exit('Please fill in all required fields.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('Invalid email format.');
}

// ==== CONNECT TO DATABASE ====
$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_error) {
    exit('Database connection failed: ' . $mysqli->connect_error);
}

// ==== INSERT INTO DATABASE ====
$stmt = $mysqli->prepare("INSERT INTO users (name, email, phone, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $phone, $message);
$stmt->execute();
$stmt->close();

// ==== SEND EMAIL ====
$mail = new PHPMailer(true);

try {
    // SMTP Settings
    $mail->isSMTP();
    $mail->Host       = $smtpHost;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtpUser;
    $mail->Password   = $smtpPass;
    $mail->SMTPSecure = $smtpSecure;
    $mail->Port       = $smtpPort;
    $mail->CharSet    = 'UTF-8';

    // Email Content
    $mail->setFrom($smtpUser, 'Website Contact Form');
    $mail->addAddress($adminEmail);

    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Submission';
    $mail->Body = "
        <h2>New Contact Form Submission</h2>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone:</strong> {$phone}</p>
        <p><strong>Message:</strong><br>{$message}</p>
    ";
    $mail->AltBody = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";

    $mail->send();
    echo '✅ Message send successfully!';
} catch (Exception $e) {
    echo "❌ Email could not be sent. Error: {$mail->ErrorInfo}";
}

$mysqli->close();
