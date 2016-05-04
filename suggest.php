<?php

require './vendor/autoload.php';
require './vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
require './config.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
	//filter the input, the first variable is the type of input
	//the second variable is the name of the variable
	//the third arugment is our filter,
	$name = trim(filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING));
	$email = trim(filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL));
	$category = trim(filter_input(INPUT_POST,"category",FILTER_SANITIZE_STRING));
	$title = trim(filter_input(INPUT_POST,"title",FILTER_SANITIZE_STRING));
	$format = trim(filter_input(INPUT_POST,"format",FILTER_SANITIZE_STRING));
	$genre = trim(filter_input(INPUT_POST,"genre",FILTER_SANITIZE_STRING));
	$year = trim(filter_input(INPUT_POST,"year",FILTER_SANITIZE_STRING));
	$details = trim(filter_input(INPUT_POST,"details",FILTER_SANITIZE_SPECIAL_CHARS));

	
	if($name == "" || $email == "" || $category == "" || $title == ""){
		$error_message = "Please fill in all fields: Name, Email, Catgory and Title";
	}
	//use isset fn to check if we have already encountered an error
	if(!isset($error_message) && $_POST["address"] != ""){
		$error_message =  "Bad form input";
	}
	
	$mail = new PHPMailer;
	
	//we only want to run this check if the error_message has not been set and the email
	//address is not valid
	if(!isset($error_message) && !$mail->ValidateAddress($email)){
		$error_message = "Invalid email address!";
	}
	//check if error message is set, if it isn't execute the email
	if(!isset($error_message)){
	
		$email_body = "";
		$email_body .= "Name " . $name . "<br/>";
		$email_body .= "Email " . $email . "<br/>";
		$email_body .= "Suggested Item<br/>";
		$email_body .= "Category " . $category . "<br/>";
		$email_body .= "Title " . $title . "<br/>";
		$email_body .= "Format " . $format . "<br/>";
		$email_body .= "Genre " . $genre . "<br/>";
		$email_body .= "Year " . $year . "<br/>";
		$email_body .= "Details " . $details . "<br/>";

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $config['email'];                 // SMTP username
		$mail->Password = $config['pass'];                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to

		$mail->setFrom($email, $name);
		$mail->addAddress($config['email'], $config['name']);     // Add a recipient

		$mail->isHTML(false);                                  // Set email format to HTML

		$mail->Subject = 'Personal Media Library Suggestion from ' . $name;
		$mail->Body    = $email_body;
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if($mail->send()) {
			header("location:suggest.php?status=thanks");
			exit;
		}
		//we could put the error message in an else block but that is not necessary
		//because we are leaving our code completely if this condition is true
		$error_message = 'Message could not be sent.';
		$error_message .= 'Mailer Error: ' . $mail->ErrorInfo;
	}	
}
//variable set above inc file to reference in header file
$pageTitle = "Suggest a Media Item";
$section = "suggest";
include('inc/header.php'); 

?>



<div class="section page">
	
	<div class="wrapper">

		<h1>Suggest a Media Item</h1>
		<?php 
		if(isset($_GET["status"]) && $_GET["status"] == "thanks"){
			echo "<p>Thanks for the email! I&rsquo;ll checkout your suggestion shortly!</p>";
		}else{ 
			if(isset($error_message)){
				echo "<p class='message'>" . $error_message . "</p>";
			}else{
				echo '<p>If you think there is something I&rsquo;m missing, let me know! Complete the form to send me an email.</p>';
			}
		?>	
		<form method="post" action="suggest.php">
			<table>
				<tr>
					<th><label for="name">Name (required)</label></th>
					<td><input type="text" id="name" name="name" value="<?php if(isset($name)) echo $name; ?>" /></td>
				</tr>
				<tr>
					<th><label for="email">Email (required)</label></th>
					<td><input type="text" id="email" name="email"  value="<?php if(isset($email)) echo $email; ?>" /></td>
				</tr>
				<tr>
					<th><label for="category">Category (required)</label></th>
					<td>
						<select id="category" name="category">
							<option value="">Select One</option>
							<!-- we will want to make sure that the value is set to the
							exact format that we are using in our array our display 
							value can be different --!>
							<option value="Books"<?php if(isset($category) && $category == "Books"){ echo " selected";} ?>>Books</option>
							<option value="Movies"<?php if(isset($category) && $category == "Movies"){ echo " selected";} ?>>Movies</option>
							<option value="Music"<?php if(isset($category) && $category == "Music"){ echo " selected";}?>>Music</option>	
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="title">Title (required)</label></th>
					<!-- this is going to stay as a text box seeing as; we need to allow					the user to type any title that they want to suggest --!>
					<td><input type="text" id="title" name="title"  value="<?php if(isset($tile)) echo $title; ?>" /></td>
				</tr>
				<tr>
					<!-- Next we will add another drop for format  --!>
					<th><label for="format">Format</label></th>
					<td>
						<select id="format" name="format">
							<!--Within our options we will leave the first blank option								and change the other three options to be optgroups instead.                             Now we can add our corresponding option tags within these                               groups  --!>
							<option value="">Select One</option><optgroup label="Books">
                            }
							
				</tr>
					

				<tr>
					<th>	
						<label for="genre">Genre</label> 
					</th>
					<td>
						<select name="genre" id="genre">
							<option value="">Select One</option>
							<optgroup label="Books">
								<option value="Action"<?php
								if (isset($genre) && $genre=="Action") {
									echo " selected";
								} ?>>Action</option>
								<option value="Adventure"<?php
								if (isset($genre) && $genre=="Adventure") {
									echo " selected";
								} ?>>Adventure</option>
								<option value="Comedy"<?php
								if (isset($genre) && $genre=="Comedy") {
									echo " selected";
								} ?>>Comedy</option>
								<option value="Fantasy"<?php
								if (isset($genre) && $genre=="Fantasy") {
									echo " selected";
								} ?>>Fantasy</option>
								<option value="Historical"<?php
								if (isset($genre) && $genre=="Historical") {
									echo " selected";
								} ?>>Historical</option>
								<option value="Historical Fiction"<?php
								if (isset($genre) && $genre=="Historical Fiction") {
									echo " selected";
								} ?>>Historical Fiction</option>
								<option value="Horror"<?php
								if (isset($genre) && $genre=="Horror") {
									echo " selected";
								} ?>>Horror</option>
								<option value="Magical Realism"<?php
								if (isset($genre) && $genre=="Magical Realism") {
									echo " selected";
								} ?>>Magical Realism</option>
								<option value="Mystery"<?php
								if (isset($genre) && $genre=="Mystery") {
									echo " selected";
								} ?>>Mystery</option>
								<option value="Paranoid"<?php
								if (isset($genre) && $genre=="Paranoid") {
									echo " selected";
								} ?>>Paranoid</option>
								<option value="Philosophical"<?php
								if (isset($genre) && $genre=="Philosophical") {
									echo " selected";
								} ?>>Philosophical</option>
								<option value="Political"<?php
								if (isset($genre) && $genre=="Political") {
									echo " selected";
								} ?>>Political</option>
								<option value="Romance"<?php
								if (isset($genre) && $genre=="Romance") {
									echo " selected";
								} ?>>Romance</option>
								<option value="Saga"<?php
								if (isset($genre) && $genre=="Saga") {
									echo " selected";
								} ?>>Saga</option>
								<option value="Satire"<?php
								if (isset($genre) && $genre=="Satire") {
									echo " selected";
								} ?>>Satire</option>
								<option value="Sci-Fi"<?php
								if (isset($genre) && $genre=="Sci-Fi") {
									echo " selected";
								} ?>>Sci-Fi</option>
								<option value="Tech"<?php
								if (isset($genre) && $genre=="Tech") {
									echo " selected";
								} ?>>Tech</option>
								<option value="Thriller"<?php
								if (isset($genre) && $genre=="Thriller") {
									echo " selected";
								} ?>>Thriller</option>
								<option value="Urban"<?php
								if (isset($genre) && $genre=="Urban") {
									echo " selected";
								} ?>>Urban</option>
							</optgroup>
							<optgroup label="Movies">
								<option value="Action"<?php
								if (isset($genre) && $genre=="Action") {
									echo " selected";
								} ?>>Action</option>
								<option value="Adventure"<?php
								if (isset($genre) && $genre=="Adventure") {
									echo " selected";
								} ?>>Adventure</option>
								<option value="Animation"<?php
								if (isset($genre) && $genre=="Animation") {
									echo " selected";
								} ?>>Animation</option>
								<option value="Biography"<?php
								if (isset($genre) && $genre=="Biography") {
									echo " selected";
								} ?>>Biography</option>
								<option value="Comedy"<?php
								if (isset($genre) && $genre=="Comedy") {
									echo " selected";
								} ?>>Comedy</option>
								<option value="Crime"<?php
								if (isset($genre) && $genre=="Crime") {
									echo " selected";
								} ?>>Crime</option>
								<option value="Documentary"<?php
								if (isset($genre) && $genre=="Documentary") {
									echo " selected";
								} ?>>Documentary</option>
								<option value="Drama"<?php
								if (isset($genre) && $genre=="Drama") {
									echo " selected";
								} ?>>Drama</option>
								<option value="Family"<?php
								if (isset($genre) && $genre=="Family") {
									echo " selected";
								} ?>>Family</option>
								<option value="Fantasy"<?php
								if (isset($genre) && $genre=="Fantasy") {
									echo " selected";
								} ?>>Fantasy</option>
								<option value="Film-Noir"<?php
								if (isset($genre) && $genre=="Film-Noir") {
									echo " selected";
								} ?>>Film-Noir</option>
								<option value="History"<?php
								if (isset($genre) && $genre=="History") {
									echo " selected";
								} ?>>History</option>
								<option value="Horror"<?php
								if (isset($genre) && $genre=="Horror") {
									echo " selected";
								} ?>>Horror</option>
								<option value="Musical"<?php
								if (isset($genre) && $genre=="Musical") {
									echo " selected";
								} ?>>Musical</option>
								<option value="Mystery"<?php
								if (isset($genre) && $genre=="Mystery") {
									echo " selected";
								} ?>>Mystery</option>
								<option value="Romance"<?php
								if (isset($genre) && $genre=="Romance") {
									echo " selected";
								} ?>>Romance</option>
								<option value="Sci-Fi"<?php
								if (isset($genre) && $genre=="Sci-Fi") {
									echo " selected";
								} ?>>Sci-Fi</option>
								<option value="Sport"<?php
								if (isset($genre) && $genre=="Sport") {
									echo " selected";
								} ?>>Sport</option>
								<option value="Thriller"<?php
								if (isset($genre) && $genre=="Thriller") {
									echo " selected";
								} ?>>Thriller</option>
								<option value="War"<?php
								if (isset($genre) && $genre=="War") {
									echo " selected";
								} ?>>War</option>
								<option value="Western"<?php
								if (isset($genre) && $genre=="Western") {
									echo " selected";
								} ?>>Western</option>
							</optgroup>
							<optgroup label="Music">
								<option value="Alternative"<?php
								if (isset($genre) && $genre=="Alternative") {
									echo " selected";
								} ?>>Alternative</option>
								<option value="Blues"<?php
								if (isset($genre) && $genre=="Blues") {
									echo " selected";
								} ?>>Blues</option>
								<option value="Classical"<?php
								if (isset($genre) && $genre=="Classical") {
									echo " selected";
								} ?>>Classical</option>
								<option value="Country"<?php
								if (isset($genre) && $genre=="Country") {
									echo " selected";
								} ?>>Country</option>
								<option value="Dance"<?php
								if (isset($genre) && $genre=="Dance") {
									echo " selected";
								} ?>>Dance</option>
								<option value="Easy Listening"<?php
								if (isset($genre) && $genre=="Easy Listening") {
									echo " selected";
								} ?>>Easy Listening</option>
								<option value="Electronic"<?php
								if (isset($genre) && $genre=="Electronic") {
									echo " selected";
								} ?>>Electronic</option>
								<option value="Folk"<?php
								if (isset($genre) && $genre=="Folk") {
									echo " selected";
								} ?>>Folk</option>
								<option value="Hip Hop/Rap"<?php
								if (isset($genre) && $genre=="Hip Hop/Rap") {
									echo " selected";
								} ?>>Hip Hop/Rap</option>
								<option value="Inspirational/Gospel"<?php
								if (isset($genre) && $genre=="Inspirational/Gospel") {
									echo " selected";
								} ?>>Insirational/Gospel</option>
								<option value="Jazz"<?php
								if (isset($genre) && $genre=="Jazz") {
									echo " selected";
								} ?>>Jazz</option>
								<option value="Latin"<?php
								if (isset($genre) && $genre=="Latin") {
									echo " selected";
								} ?>>Latin</option>
								<option value="New Age"<?php
								if (isset($genre) && $genre=="New Age") {
									echo " selected";
								} ?>>New Age</option>
								<option value="Opera"<?php
								if (isset($genre) && $genre=="Opera") {
									echo " selected";
								} ?>>Opera</option>
								<option value="Pop"<?php
								if (isset($genre) && $genre=="Pop") {
									echo " selected";
								} ?>>Pop</option>
								<option value="R&B/Soul"<?php
								if (isset($genre) && $genre=="R&B/Soul") {
									echo " selected";
								} ?>>R&amp;B/Soul</option>
								<option value="Reggae"<?php
								if (isset($genre) && $genre=="Reggae") {
									echo " selected";
								} ?>>Reggae</option>
								<option value="Rock"<?php
								if (isset($genre) && $genre=="Rock") {
									echo " selected";
								} ?>>Rock</option>
							</optgroup>
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="year">Year</label></th>
					<td><input type="text" id="year" name="year"  value="<?php if(isset($year)) echo $year; ?>" /></td>
				</tr>
				<tr>
					<th><label for="details">Additional Details</label></th>
					<td><textarea name="details" id="details"><?php if(isset($details)) echo $details; ?></textarea></td>
				</tr>
				<tr style="display:none;">
					<th><label for="address">Address</label></th>
					<td><input type="hidden" id="address" name="address" />
					<p>Please leave this field blank</p>
					</td>
				</tr>
			</table>	

			<input type="submit" value="Send" />

		</form>
		<?php } ?>
	</div>

</div>


<?php include('inc/footer.php'); ?>

