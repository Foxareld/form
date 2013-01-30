<?php


//        Who you want to recieve the emails from the form. (Hint: generally you.)
$sendto = 'bbielefeldt@thepowertoprovoke.com';
$sendFrom = 'webmaster@diguiseppi.com';

//        Message for the user when he/she doesn't fill in the form correctly.
$errormessage = 'Oops! There seems to have been a problem. May we suggest...';

//        Message for the user when he/she fills in the form correctly.
$thanks = "Thanks for the email! We'll get back to you as soon as possible!";

//        Message for the bot when it fills in in at all.
$honeypot = "You filled in the honeypot! If you're human, try again!";

//        Various messages displayed when the fields are empty.
$emptyname =  'Entering your First Name?';
$emptylname =  'Entering your Last Name?';
$emptyemail = 'Entering your Email Address?';
$emptymessage =  'Entering your Message?';
$emptyaddress = 'Entering your Address?';
$emptycity = 'Entering your City?';
$emptystate = 'Entering your State?';
$emptyzip = 'Entering your Zip Code?';

//       Various messages displayed when the fields are incorrectly formatted.
$alertname =  'Entering your First Name using only the standard alphabet?';
$alertlname =  'Entering your Last Name using only the standard alphabet?';
$alertsub =  'Entering your Subject using only the standard alphanumeric characters, no puctuation.';
$alertemail = 'Entering your Email in this format: <i>name@example.com</i>?';
$alertmessage =  'Entering your Message using only the standard alphabet?';
$alertaddress = 'Entering your Address using only the standard alphabet?';
$alertcity = 'Entering your City using only the standard alphanumeric characters, no puctuation.';
$alertstate = 'Entering your State using only the standard alphanumeric characters, no puctuation.';
$alertzip = 'Entering your Zip Code using only the standard alphanumeric characters, no puctuation.';


// --------------------------- Thats it! don't mess with below unless you are really smart! ---------------------------------

//Setting used variables.
$alert = '';
$pass = 0;

// Sanitizing the data, kind of done via error messages first. Twice is better!
function clean_var($variable) {
    $variable = strip_tags(stripslashes(trim(rtrim($variable))));
  return $variable;
}

//The first if for honeypot.
if ( empty($_REQUEST['last']) ) {

	// A bunch of if's for all the fields and the error messages.
	// first name
	if ( isset($_REQUEST['name']) && empty($_REQUEST['name']) ) {
		$pass = 1;
		$alert .= "<li>" . $emptyname . "</li>";
	} elseif ( isset($_REQUEST['name']) && ereg( "[][{}()*+?.\\^$|]", $_REQUEST['name'] ) ) {
		$pass = 1;
		$alert .= "<li>" . $alertname . "</li>";
	} 
	// last name
	if ( isset($_REQUEST['lname']) && empty($_REQUEST['lname']) ) {
		$pass = 1;
		$alert .= "<li>" . $emptylname . "</li>";
	} elseif ( isset($_REQUEST['lname']) && ereg( "[][{}()*+?.\\^$|]", $_REQUEST['lname'] ) ) {
		$pass = 1;
		$alert .= "<li>" . $alertlname . "</li>";
	} 
	//city
	if ( isset($_REQUEST['city']) && empty($_REQUEST['city']) ) {
		$pass = 1;
		$alert .= "<li>" . $emptycity . "</li>";
	} elseif ( isset($_REQUEST['city']) && ereg( "[][{}()*+?.\\^$|]", $_REQUEST['city'] ) ) {
		$pass = 1;
		$alert .= "<li>" . $alertcity . "</li>";
	} 
	// state
	if ( isset($_REQUEST['state']) && empty($_REQUEST['state']) ) {
		$pass = 1;
		$alert .= "<li>" . $emptystate . "</li>";
	} elseif ( isset($_REQUEST['state']) && ereg( "[][{}()*+?.\\^$|]", $_REQUEST['state'] ) ) {
		$pass = 1;
		$alert .= "<li>" . $alertstate . "</li>";
	} 
	// zip
	if ( isset($_REQUEST['zip']) && empty($_REQUEST['zip']) ) {
		$pass = 1;
		$alert .= "<li>" . $emptyzip . "</li>";
	} elseif ( isset($_REQUEST['zip']) && ereg( "[][{}()*+?.\\^$|]", $_REQUEST['zip'] ) ) {
		$pass = 1;
		$alert .= "<li>" . $alertzip . "</li>";
	} 
	//subject
	if ( isset($_REQUEST['subject']) && empty($_REQUEST['subject']) ) {
		$subject = 'Inquiry submited from Response Site';
	} elseif (isset($_REQUEST['subject']) && ereg( "[][{}()*+?.\\^$|]", $_REQUEST['subject'] ) ) {
		$pass = 1;
		$alert .= "<li>" . $alertsub . "</li>";
	}
	// email
	if (isset($_REQUEST['email']) && empty($_REQUEST['email']) ) {
		$pass = 1;
		$alert .= "<li>" . $emptyemail . "</li>";
	} elseif ( isset($_REQUEST['email']) && !eregi("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$", $_REQUEST['email']) ) {
		$pass = 1;
		$alert .= "<li>" . $alertemail . "</li>";
	}
	// message
	if (isset($_REQUEST['message']) && empty($_REQUEST['message']) ) {
		$pass = 1;
		$alert .= "<li>" . $emptymessage . "</li>";
	} elseif (isset($_REQUEST['message']) && ereg( "[][{}()*+<>\\^|]", $_REQUEST['message'] ) ) {
		$pass = 1;
		$alert .= "<li>" . $alertmessage . "</li>";
	}
	// address
	if (isset($_REQUEST['address']) && empty($_REQUEST['address']) ) {
		$pass = 1;
		$alert .= "<li>" . $emptyaddress . "</li>";
	} elseif ( isset($_REQUEST['address']) && ereg( "[][{}()*+<>\\^|]", $_REQUEST['address'] ) ) {
		$pass = 1;
		$alert .= "<li>" . $alertaddress . "</li>";
	}
	

	//If the user err'd, print the error messages.
	if ( $pass==1 ) {

		//This first line is for ajax/javascript, comment it or delete it if this isn't your cup o' tea.
	echo "<script>$(\".message\").hide(\"slow\").show(\"slow\"); </script>";
	echo "<b>" . $errormessage . "</b>";
	echo "<ul class='no_margin no_padding'>";
	echo $alert;
	echo "</ul>";

	// If the user didn't err and there is in fact a message, time to email it.
	} elseif ( $pass==0 ) {
	    $variables = array();
	    // define runtime variables
	    if (isset($_REQUEST['name'])) {
	    	$name = clean_var($_REQUEST['name']);
	    	$variables["name"] = $name;
	    	//var_dump($variables);
	    }
	    if (isset($_REQUEST['lname'])) {
	    	$lname = clean_var($_REQUEST['lname']);
	    	$variables['lname'] = $lname;
	    }
	    if (isset($_REQUEST['email'])) {
	    	$email = clean_var($_REQUEST['email']);
	    	$variables['email'] = $email;
	    }
	    if (isset($_REQUEST['address'])) {
	    	$address = clean_var($_REQUEST['address']);
	    	$variables['address'] = $address;
	    }
	    if (isset($_REQUEST['city']) ){
	    	$city = clean_var($_REQUEST['city']);
	    	$variables['city'] = $city;
	    }
	    if (isset($_REQUEST['state'])) {
	    	$state = clean_var($_REQUEST['state']);
	    	$variables['state'] = $state;
	    }
	    if (isset($_REQUEST['zip']) ){
	    	$zip = clean_var($_REQUEST['zip']);
	    	$variables['zip'] = $zip;
	    }
	    // get any checkbox values
	    if (isset($_REQUEST['newsletter'])) {
	    	if ($_REQUEST['newsletter'] == 1) {
	    		$newsletter = "(YES) Send me your newsletter";
	    	} else {
	    		$newsletter = "(NO) I don&lsquo;t want your newsletter";
	    	}
	    	$variables['newsletter'] = $newsletter;
	    }
	    if (isset($_REQUEST['services'])) {
	    	for ($i = 0; $i < count($_REQUEST['services']); $i++) {
	    	   // Do something here with $_POST['checkbx'][$i]
	    	   $services[$i] = clean_var($_REQUEST['services'][$i]);
	    	}
	    	// var_dump($services);
	    	$variables['services'] = $services;
	    }
	    if (isset($_REQUEST['subject'])) {
	    	$subject = clean_var($_REQUEST['subject']);
	    	$variables['subject'] = $subject;
	    }	
	    if (isset($_REQUEST['message'])) {
	    	$message = clean_var($_REQUEST['message']);
	    	$variables['message'] = $message;
	    }
	    var_dump($variables);
		//Construct the message.
		$message = "\n\nAn inquiry has been submitted on you website, please use the information provided below to follow up.\n\n";
	    $message .= "From: " . $variables['name'] . " ". $variables['lname'] . "\n";
		$message .= "Email: " . $variables['email'] . "\n";
	    $message .= "Message: " . clean_var($_REQUEST['message']) . "\n";
	    $subject = clean_var($_REQUEST['subject']);
	    $header = 'From:'. $sendFrom;
	    
//Mail the message - for production
		mail($sendto, $subject, $message, $header);
//This is for javascript, 
		echo "<script>$(\".message\").hide(\"slow\").show(\"slow\").animate({opacity: 1.0}, 4000); $('form#contactform').hide(\"slow\"); </script>";
		echo $thanks;

		die();
	}
//Echo the email message - for development
		//echo "<br/><br/>" . $message;

	
//If honeypot is filled, trigger the message that bot likely won't see.
} else {
	echo "<script>$(\".message\").hide(\"slow\").show(\"slow\"); </script>";
	echo $honeypot;
}
?>
