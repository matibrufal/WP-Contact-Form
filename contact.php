<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Contact Form</title>
</head>
<body>

<?php

	// Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["thename"]));
		$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        $email_recipient = get_field('email', 79);
        $email_subject = "New contact from $name";

        // Build the email headers.
	    $email_headers = 'MIME-Version: 1.0' . "\r\n";
	    $email_headers .= 'Content-type: text/html; charset="'. get_bloginfo('charset') .'"' . "\r\n";
		$email_headers .= 'From: '. $name .' <"'. $email .'">' . "\r\n";


        // Build the email content.
        $email_content = '
		<html>
		<body>
			<table cellpadding="10px" cellspacing="0" border="0" style=; border-radius: 4px">
				<tr>
					<td><strong>Name:</strong></td>
					<td>'. $name .'</td>
				</tr>
				<tr>
					<td><strong>E-mail:</strong></td>
					<td>'. $email .'</td>
				</tr>
				<tr>
					<td colspan="2"><strong>Message:</strong></td>
				</tr>
				<tr>
					<td colspan="2">'. $message .'</td>
				</tr>
			</table>
		</body>
		</html>
		';


        // Send the email.
        if (mail($email_recipient, $email_subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
        }

	}

?>

<!-- CONTACT -->

<section id="contact">
	<div class="container">

		<form id="contactform" name="contact" action="#" method="POST">

			<div id="name-group">
				<input type="text" id="name" class="form-control" name="thename" placeholder="Name" />
				<span class="alert name-alert"></span>
			</div>

			<div id="email-group">
				<input type="email" id="email" class="form-control" name="email" placeholder="Email" />
				<span class="alert email-alert"></span>
			</div>

			<div id="message-group">
				<textarea id="message" class="form-control" name="message" placeholder="Message..."></textarea>
				<span class="alert message-alert"></span>
			</div>

			<button type="submit" class="btn btn-lg btn-primary">Send</button>

		</form>

	</div>
</section>

</body>
</html>