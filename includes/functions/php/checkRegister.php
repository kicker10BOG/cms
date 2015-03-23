<?php
	//$reatemptRegister = false;
	$passwordValue = trim($_REQUEST['password']);
	$passwordVValue = trim($_REQUEST['passwordV']);
	$emailValue = trim($_REQUEST['email']);
	$nameValue = trim($_REQUEST['fullName']);
    if(isset($_REQUEST['checkRegister'])){
        function CheckEmail($emailValue) {
            // make sure it hasn't been used for registration already
            $query = "SELECT id FROM ".$sitePrefix."users WHERE email='".$emailValue."'";
            $result = mysql_query($query);
            if(!$result) {
                $specialMsg = "<p class=\"cent\">Unable to check your email against our database. </p>";
                return false;
            }
            if(mysql_num_rows($result) > 0) {
                $specialMsg = " <p class=\"cent\"> This email address is already in use. Please use another one.</p>";
                return false;
            }
            // checks proper syntax
            if(preg_match('/[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $emailValue))
            {
                // gets domain name
                list($username,$domain) = explode('@',$emailValue);
                // checks for if MX records in the DNS
                if(!checkdnsrr($domain, $type='MX'))
                {
                    return false;
                }
                // attempts a socket connection to mail server
                /*if(!fsockopen($domain,80,$errno,$errstr,10))
                {
                    return false;
                }*/
                return true;
            }
            return false;
        }
        function CheckPasswords($pass, $passV) {
            if(strlen($pass) < 7) {
                return false;
            }
            if($pass !== $passV) {
                return false;
            }
            return true;
        }
        //NEED TO CHECK IF FIELDS ARE FILLED IN
        if (filter_var($emailValue, FILTER_VALIDATE_EMAIL)){
            if (CheckPasswords($passwordValue, $passwordVValue)){
                if(isset($_REQUEST['fullName'])) {
                    $verificationCode = md5($nameValue).md5($emailVaue).md5($PasswordValue);
                    $emailSubject = "Jason L Bogle Web. Registration";
                    $emailMessage = $nameValue.", thank you for registering with my website.<br><br>Visit http://www.dev.jasonlbogle.com/pid=1&&vcode=".$verificationCode." to complete your registration.";
                    $emailHeaders = "Content-type: text/html; charset=iso-8859-1\r\nFrom: DoNotReply@jasonlbogle.com\r\n";
                    // insert into database
                    $query = "INSERT INTO ".$sitePrefix."users (name, email, password, verCode, usertype) VALUES ('".$nameValue."', '".$emailValue."', '".md5($passwordValue)."', '".$verificationCode."', 'member')";
                    $result = mysql_query($query) or die(mysql_error());
					if (mail($emailValue,$emailSubject, $emailMessage, $emailHeaders)) {
                        $specialMsg = "<p class=\"cent\">A verification email has been sent to the provided email address. Please finish your registration by clicking the link in it.</p>";
                    }
				  else {
                    $specialMsg = "<p class=\"cent\">All fields are required.</p>";
                    include("./includes/functions/php/register.php");
				  }
                }
                else {
                    $specialMsg = "<p class=\"cent\">We would like to know your name, but will only display it with your permission.</p>";
                    include("./includes/functions/php/register.php");
                }
            }
            else{
                $specialMsg = "<p class=\"cent\">Your passwords must match and be at least 7 characters long.</p>";
                include("./includes/functions/php/register.php");
            }
        }
        else {
                $specialMsg = "<p class=\"cent\">Your email address appears to be invalid. Please check to make sure it is correct.</p>";
                //include("./includes/functions/php/register.php");
        }
    }
    elseif(isset($_REQUEST['vcode'])) {
        $vcode = $_REQUEST['vcode'];
        $query = "SELECT email, securitylevel FROM ".$sitePrefix."users WHERE verCode='$vcode'";
        $result = mysql_query($query);
        if (!$result)// || mysql_num_rows($result) == 0)
            $specialMsg = "<p class=\"cent\">An error 1 connection has occurred.</p>";
        else {
            $row = mysql_fetch_array($result);
            if($row['securitylevel'] != 0) {
                $specialMsg = "The user with this verification code has already used it.";
            }
            else {
                $query = "UPDATE users SET securitylevel=1 WHERE verCode='$vcode'";
                $result = mysql_query($query);
                if (!$result)
                    $specialMsg = "<p class=\"cent\">An error 2 has occurred.</p>";
                else
                    $specialMsg = "<p class=\"cent\">Thank you for completing your registration.</p>";
            }
        }
    }
    else {
        $specialMsg = "<p class=\"cent\">How did you get here? You should not be on this page if you did not fill out the registration form. Please register for Choc An.</p>";
        include("./includes/functions/php/register.php");
    }