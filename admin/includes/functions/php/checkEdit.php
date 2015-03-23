<?php
	$passwordValue = trim($_REQUEST['password']);
	$passwordVValue = trim($_REQUEST['passwordV']);
	$emailValue = trim($_REQUEST['email']);
        function CheckEmail($emailValue) {
            // make sure it hasn't been used for registration already
            $query = "SELECT id FROM ".$sitePrefix."users WHERE email='".$emailValue."'";
            $result = mysql_query($query);
            if(!$result) {
                $specialMsg .= "<p class=\"cent\">Unable to check your email against our database. </p>";
                return false;
            }
            if(mysql_num_rows($result) > 0) {
                $specialMsg .= "<p class=\"cent\"> This email address is already in use. Please use another one.</p>";
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
		  if (!empty($pass)) {
            if(strlen($pass) < 7) {
                return false;
            }
            if($pass !== $passV) {
                return false;
            }
			$query = "UPDATE ".$sitePrefix."users SET password='".md5($pass)."' WHERE email='".$_COOKIE['manbizdire']."'";
			$result = mysql_query($query);
			if (!$result) {
			  $specialMsg .= "<p class=\"cent\">unable to update passwords.</p>";
			  return false;
			}
			else
			  setcookie("manbizdirp", sha1(md5($pass)), time()+60*60*24*30);
		  }
          return true;
        }
        //NEED TO CHECK IF FIELDS ARE FILLED IN
        if ($emailValue == $_COOKIE[manbizdire] || CheckEmail($emailValue)) {
            if (CheckPasswords($passwordValue, $passwordVValue)) {
                if(isset($_REQUEST['fullName'])) {
                    // edit database
                    $query = "UPDATE users SET name='$nameValue', email='$emailValue', streetaddress='$stAddValue', city='$cityValue', state='$stateValue', zipcode='$zipValue' WHERE email='".$_COOKIE['manbizdire']."'";
                    $result = mysql_query($query);
					$specialMsg = "You successfully updated your info.";
					header("Location: index.php?pid=8&specialMsg=$specialMsg");
					die();
                    if (!$result)
                        $specialMsg .= "<p class=\"cent\">Unable to update user.... Query was - ".$query." ... error was - ".mysql_error()."</p>";
					else {
					  setcookie("manbizdire", $emailValue, time()+60*60*24*30);
					  $specialMsg .= "<p class=\"cent\">Succsfully updated your info.</p>";
					}
				}
                else 
                    $specialMsg .= "<p class=\"cent\">We would like to know your name, but will only display it with your permission.</p>";
            }
            else
                $specialMsg .= "<p class=\"cent\">Your passwords must match and be at least 7 characters long.</p>";
        }
        else 
            $specialMsg .= "<p class=\"cent\">Your email address appears to be invalid. Please check to make sure it is correct.</p>";