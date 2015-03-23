<?php
  class Member
  {
    private $id;
	private $email;
	private $userName;
    private $loggedin;
    private $securityLevel;
	
	function InitializeUser() {
	  if (isset($_COOKIE[manbizdirl])) {
		if ($_REQUEST['action'] == "logout") {
		 setcookie("manbizdirl", "", time()-7200);
		 setcookie("manbizdire", "", time()-7200);
		 setcookie("manbizdirp", "", time()-7200);
		 setcookie("manbizdirs", "", time()-7200);
		 setcookie("manbizdirt", "", time()-7200);
		 setcookie("manbizdirr", "", time()-7200);
		 header("Location: ./");
		 die();
		}
		if ($_COOKIE[manbizdirl] == md5("loggedin")) {
		  if (isset($_COOKIE[manbizdire])) {
			if (!empty($_COOKIE[manbizdire])) {
			  $this->email = $_COOKIE[manbizdire];
			  $query = "SELECT id, password, securityLevel, usertype FROM users WHERE email='".$this->email."'";
			  $result = mysql_query($query);
			  if ($result) {
				if (mysql_num_rows == 0) {
				  if (isset($_COOKIE[manbizdirp])) {
					if (!empty($_COOKIE[manbizdirp])) {
					  $row = mysql_fetch_array($result);
					  $password = $_COOKIE[manbizdirp];
					  if ($password == sha1($row['password'])) {
						if (isset($_COOKIE[manbizdirs])) {
						  if (!empty($_COOKIE[manbizdirs])) {
							$this->securityLevel = $_COOKIE[manbizdirs];
							if ($this->securityLevel == $row['securityLevel']) {
							  if (isset($_COOKIE[manbizdirt])) {
								if (!empty($_COOKIE[manbizdirt])) {
								  $userType = $row['usertype'];
								  if (isset($_COOKIE[manbizdirr])) {
									if (!empty($_COOKIE[manbizdirr])) {
									  $loggedin = "yes";
									  $userStatus = $status;
									  if ($_COOKIE['manbizdirr'] == 1){ // reset expiration time
										setcookie("manbizdirl", md5("loggedin"), time()+60*60*24*30);
										setcookie("manbizdire", $email, time()+60*60*24*30);
										setcookie("manbizdirp", sha1(md5($password)), time()+60*60*24*30);
										setcookie("manbizdirs", $status, time()+60*60*24*30);
										setcookie("manbizdirt", $userType, time()+60*60*24*30);
										setcookie("manbizdirr", md5($rememberMe), time()+60*60*24*30);
										$this->id = $row['id'];
									  }
									}
									else // rememberMe cookie empty
									  CookieError("r cookie empty");
								  }
								  else // rememberMe cookie not set
									CookieError("r cookie not set");
								}
								else // type cookie empty
								  CookieError("type cookie empty");
							  }
							  else // type cookie not set
								CookieError("type cookie not set");
							}
							else // status cookie data invalid
							  CookieError("status cookie data invalid");
						  }
						  else // status cookie set to 0
							CookieError("Please check your email and click the verifiction link.");
						}
						else // status cookie not set
						  CookieError("status cookie not set");
					  }
					  else // passwrd cookie incorrect
						CookieError("passwrd cookie incorrect");
					}
					else // password cookie empty
					  CookieError("password cookie empty");
				  }
				  else // password cookie not set
					CookieError("password cookie not set");
				}
				else // email not in database
				  CookieError("email not in database");
			  }
			  else // error while checking database database
				DBErroror("error while checking database database");
			}
			else // login cookie set, but empty
			  CookieError("login cookie set, but empty");
		  }
		  else // email cookie not set
			CookieError("email cookie not set");
		}
		else // login cookie invalid
		  CookieError("login cookie invalid");
	  }
	  else { // login cookie not set
		if (isset($_REQUEST['checkRegister']) || isset($_REQUEST['vcode']))
		  include($php_function_dir."checkRegister.php");
	  }
	  if ($loggedin != "yes") {
		$loggedin = "no";
		$userStatus = 0;
		$userType = "";
	  }
	}
    
    public function GetID() {
      return $this->id;
    }
    
    public function GetPass() {
      return $this->pass;
    }
    
    public function SetID($uid) {
      $this->id = $uid;
    }
    
    public function SetPass($uPass) {
      $this->pass = $uPass;
    }
  }
?>