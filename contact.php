

<?php
// Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Set Content-Type to application/json
header('Content-Type: application/json');

$servername = "sql209.infinityfree.com"; 
$username = "if0_37066536"; 
$password = "OUNrc7ZXRs6s"; 
$dbname = "if0_37066536_portfolio"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO contacts2 (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);

// Execute the query
if ($stmt->execute()) {
    // Send an automated email response
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sharma272k3@gmail.com'; 
        $mail->Password   = 'pjdg tbmx bkkg qslw'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('sharma272k3@gmail.com', 'Pravin Sharma'); 
        $mail->addAddress($email, $name); 

        // Content
        // $mail->isHTML(true);
        // $mail->Subject = 'Thank you for contacting us!';
        // $mail->Body    = "Dear $name,<br><br>Thank you for reaching out to us. We have received your message:<br><br>\"$message\"<br><br>We will get back to you soon.<br><br>Best regards,<br>Pravin Sharma";

        // $mail->send();

        // Content
$mail->isHTML(true);
$mail->Subject = 'Thank you for contacting us!';

// Create a visually appealing HTML structure
$mail->Body = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }
        h1 {
            color: #333;
        }
        h2 {
            color: #007bff;
        }
        p {
            color: #555;
            line-height: 1.5;
        }
        .message {
            background-color: #e9f7ef;
            border-left: 5px solid #28a745;
            padding: 10px;
            margin: 20px 0;
            font-style: italic;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .experience {
            margin-top: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
        }
        .social-links {
            margin-top: 20px;
        }
        .social-links a {
            margin-right: 10px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>Thank You for Contacting Us!</h1>
        <p>Dear $name,</p>
        <p>Thank you for reaching out to us. We have received your message:</p>
        <div class='message'>\"$message\"</div>
        <p>We will get back to you soon.</p>

        <h2>My Professional Experience</h2>
        <div class='experience'>
            <p>I work as a website developer, specializing in both front-end and back-end development. I am also skilled in UI/UX design, ensuring that the websites I create not only function well but also have an appealing and user-friendly interface.</p>
        </div>

        <h2>Stay Connected</h2>
        <p>Follow me on social media for updates and projects:</p>
        <div class='social-links'>
            <a href='https://www.linkedin.com/in/pravin-sharma-505282285/' target='_blank'>LinkedIn</a>
            <a href='https://github.com/known-27' target='_blank'>GitHub</a>
        </div>

        <h2>Contact Me</h2>
        <p>If you have any further questions or would like to discuss a project, feel free to reach out:</p>
        <p>Email: sharma272k3@example.com<br>Phone: +91 9508715362</p>

        <p>Best regards,<br>Pravin Sharma</p>
        <a href='https://shinigami.free.nf/' class='button'>Visit My Website</a>
    </div>
</body>
</html>
";

$mail->send();

        echo json_encode(['success' => true, 'message' => 'Your message has been sent successfully! An email confirmation has been sent.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => "Email could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error submitting your message. Please try again.']);
}

// Close the connection
$stmt->close();
$conn->close();
?>
